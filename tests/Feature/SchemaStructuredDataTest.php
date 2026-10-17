<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchemaStructuredDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_hvac_business_and_website_search_schema(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('"@type": "HVACBusiness"', false);
        $response->assertSee('"@type": "WebSite"', false);
        $response->assertSee('SearchAction', false);
        $response->assertSee('+971503692131', false);
        $response->assertSee('info@hvaclinic.com', false);
    }

    public function test_single_blog_post_renders_article_and_breadcrumbs_and_faqs_schema(): void
    {
        $user = User::factory()->create();
        $cat = Category::create([
            'name' => 'Chiller Maintenance',
            'slug' => 'chiller-maintenance',
        ]);

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Chiller Preventive AMC Guide UAE',
            'slug' => 'chiller-preventive-amc-guide-uae',
            'content' => '<p>Detailed guide on HVAC chillers in Dubai.</p>
                <details><summary>How often should chillers be serviced?</summary><div>Chillers in UAE ambient conditions require quarterly oil checks and monthly filter cleans.</div></details>',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);
        $post->categories()->attach($cat->id);

        $response = $this->get('/chiller-preventive-amc-guide-uae');

        $response->assertStatus(200);
        $response->assertSee('"@type": "Article"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee('"@type": "FAQPage"', false);
        $response->assertSee('How often should chillers be serviced?', false);
        $response->assertSee($user->name, false);
    }

    public function test_service_page_renders_service_and_breadcrumbs_and_faqs_schema(): void
    {
        $service = Service::create([
            'title' => 'Rental Chiller Solutions',
            'slug' => 'rental-chiller-solutions',
            'content' => '<p>High efficiency cooling rental.</p>
                <details><summary>What chiller tonnages are available?</summary><div>We supply from 50 TR up to 1,500 TR air-cooled chillers across UAE.</div></details>',
            'status' => 'published',
        ]);

        $response = $this->get('/services/rental-chiller-solutions');

        $response->assertStatus(200);
        $response->assertSee('"@type": "Service"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee('"@type": "FAQPage"', false);
        $response->assertSee('What chiller tonnages are available?', false);
        $response->assertSee('Rental Chiller Solutions', false);
    }

    public function test_services_index_renders_itemlist_and_breadcrumbs_schema(): void
    {
        Service::create([
            'title' => 'Rental Cooling',
            'slug' => 'rental-cooling-test',
            'status' => 'published',
        ]);

        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('"@type": "ItemList"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
    }

    public function test_pages_render_appropriate_schema_types(): void
    {
        Page::create([
            'title' => 'About HVAC Clinic',
            'slug' => 'about',
            'status' => 'published',
            'content' => '<p>About HVAC Clinic history.</p>',
        ]);

        $responseAbout = $this->get('/about');
        $responseAbout->assertStatus(200);
        $responseAbout->assertSee('AboutPage', false);

        $responseContact = $this->get('/contact');
        $responseContact->assertStatus(200);
        $responseContact->assertSee('ContactPage', false);
    }

    public function test_all_rendered_json_ld_blocks_are_valid_json(): void
    {
        $user = User::factory()->create();
        Post::create([
            'user_id' => $user->id,
            'title' => 'Sample Json Validity Article',
            'slug' => 'sample-json-validity-article',
            'content' => '<p>Sample text</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/sample-json-validity-article');
        $html = $response->getContent();

        preg_match_all('/<script\b[^>]*type=[\'"]application\/ld\+json[\'"][^>]*>(.*?)<\/script>/is', $html, $matches);

        $this->assertNotEmpty($matches[1], 'Expected at least one application/ld+json block.');

        foreach ($matches[1] as $index => $jsonString) {
            $decoded = json_decode($jsonString, true);
            $this->assertNotNull($decoded, "Failed to decode JSON-LD block #{$index}: ".json_last_error_msg());
            $this->assertFalse(str_contains($jsonString, '__contextArgs'), "JSON-LD block #{$index} contains unescaped Blade tokens.");
        }
    }
}
