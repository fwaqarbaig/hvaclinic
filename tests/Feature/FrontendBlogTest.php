<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('HVAC Clinic');
        $response->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1">', false);
    }

    public function test_blog_index_loads_successfully_and_shows_published_posts(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Sample Public Article',
            'slug' => 'sample-public-article',
            'content' => '<p>Article content</p>',
            'status' => 'published',
            'published_at' => now()->subHour(),
        ]);

        $response = $this->get('/blog');
        $response->assertStatus(200);
        $response->assertSee('Sample Public Article');
    }

    public function test_single_post_renders_with_seo_meta_tags(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Article with SEO',
            'slug' => 'article-with-seo',
            'content' => '<p>Rich article content</p>',
            'status' => 'published',
            'published_at' => now()->subHour(),
            'meta_title' => 'Targeted SEO Title for Crawlers',
            'meta_description' => 'Targeted meta description for Google index.',
            'meta_keywords' => 'keyword1, keyword2',
            'is_indexable' => true,
        ]);

        $redirectResponse = $this->get('/post/article-with-seo');
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect('/article-with-seo/');

        $response = $this->get('/article-with-seo');
        $response->assertStatus(200);
        $response->assertSee('<title>Targeted SEO Title for Crawlers', false);
        $response->assertSee('content="Targeted meta description for Google index."', false);
        $response->assertSee('content="keyword1, keyword2"', false);
    }

    public function test_static_page_renders_with_seo_meta(): void
    {
        $user = User::factory()->create();

        $page = Page::create([
            'user_id' => $user->id,
            'title' => 'Company Mission',
            'slug' => 'company-mission',
            'content' => '<p>Our company values and vision.</p>',
            'status' => 'published',
            'meta_title' => 'Company Mission Statement',
            'meta_description' => 'Learn about our core principles.',
        ]);

        $redirectResponse = $this->get('/page/company-mission');
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect('/company-mission/');

        $response = $this->get('/company-mission');
        $response->assertStatus(200);
        $response->assertSee('Company Mission Statement');
        $response->assertSee('Our company values and vision.', false);
    }

    public function test_draft_post_returns_404_for_guest(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Draft Post Title',
            'slug' => 'draft-post-title',
            'content' => '<p>Secret content</p>',
            'status' => 'draft',
        ]);

        $response = $this->get('/draft-post-title');
        $response->assertStatus(404);
    }

    public function test_author_name_is_not_displayed_on_blog_pages(): void
    {
        $user = User::factory()->create([
            'name' => 'Shafia Begum',
        ]);

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Comprehensive Data Recovery Strategy',
            'slug' => 'comprehensive-data-recovery-strategy',
            'content' => '<p>Data recovery guide details.</p>',
            'status' => 'published',
            'published_at' => now()->subHour(),
        ]);

        // Blog listing
        $blogResponse = $this->get('/blog');
        $blogResponse->assertStatus(200);
        $blogResponse->assertSee('Comprehensive Data Recovery Strategy');
        $blogResponse->assertDontSee('Shafia Begum');

        // Single post
        $showResponse = $this->get('/comprehensive-data-recovery-strategy');
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Comprehensive Data Recovery Strategy');
        $showResponse->assertSee('"name": "Shafia Begum"', false);
        $showResponse->assertDontSee('Written by');

        // Numeric author ID 301-redirects to slug-based URL
        $authorResponse = $this->get('/author/'.$user->id);
        $authorResponse->assertStatus(301);
        $authorResponse->assertRedirect(route('author.show', $user->slug));

        // Slug-based author URL renders successfully
        $slugResponse = $this->get('/author/'.$user->slug);
        $slugResponse->assertStatus(200);
        $slugResponse->assertSee('Shafia Begum');
        $slugResponse->assertSee('Comprehensive Data Recovery Strategy');
    }

    public function test_single_post_renders_with_service_right_sidebar_including_form_hotline_and_services(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Chiller Maintenance Best Practices in UAE',
            'slug' => 'chiller-maintenance-best-practices-in-uae',
            'content' => '<p>Deep technical article detailing industrial chiller maintenance.</p>',
            'status' => 'published',
            'published_at' => now()->subHour(),
        ]);

        $response = $this->get('/chiller-maintenance-best-practices-in-uae');
        $response->assertStatus(200);

        // Right sidebar contact card
        $response->assertSee('24/7 Rapid Emergency Dispatch');
        $response->assertSee('Need Equipment on Site?');
        $response->assertSee('+971 50 369 2131');
        $response->assertSee(route('contact.submit'));
    }

    public function test_blog_sidebar_evaluation_form_submits_successfully(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Khalid Al Nuaimi',
            'phone' => '+971 50 999 8888',
            'email' => 'khalid@example.ae',
            'message' => 'Need emergency 200 TR rental chiller for manufacturing plant in Dubai.',
            'subject' => 'Emergency Cooling Inquiry',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Khalid Al Nuaimi',
            'email' => 'khalid@example.ae',
            'phone' => '+971 50 999 8888',
        ]);
    }

    public function test_pages_render_valid_json_ld_schema_with_unescaped_context(): void
    {
        $user = User::factory()->create();

        Page::create([
            'user_id' => $user->id,
            'title' => 'About HVAC Clinic',
            'slug' => 'about',
            'content' => '<p>About HVAC Clinic cooling and power solutions.</p>',
            'status' => 'published',
        ]);

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Valid Schema Test Post',
            'slug' => 'valid-schema-test-post',
            'content' => '<p>Post content with schema</p>',
            'status' => 'published',
            'published_at' => now()->subHour(),
        ]);

        $urls = ['/', route('post.show', $post->slug), route('about'), route('contact')];

        foreach ($urls as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);

            $html = $response->getContent();

            // Ensure no Blade context directive artifacts leak into HTML
            $this->assertStringNotContainsString('__contextArgs', $html);
            $this->assertStringNotContainsString('context()->has', $html);

            // Extract all JSON-LD scripts
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);
            $this->assertNotEmpty($matches[1], "No JSON-LD found on {$url}");

            foreach ($matches[1] as $rawJson) {
                $decoded = json_decode(trim($rawJson), true);
                $this->assertNotNull($decoded, "Failed to decode JSON-LD on {$url}");
                $this->assertArrayHasKey('@context', $decoded, "Missing @context property on {$url}");
                $this->assertEquals('https://schema.org', $decoded['@context']);
            }
        }
    }
}
