<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternalLinkingArchitectureTest extends TestCase
{
    use RefreshDatabase;

    protected User $author;

    protected Service $chillerService;

    protected Service $coolingService;

    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create(['role' => 'admin', 'slug' => 'hvaclinic']);

        $this->chillerService = Service::create([
            'title' => 'Rental Chiller in UAE',
            'slug' => 'rental-chiller-in-uae',
            'summary' => 'High-capacity emergency air and water-cooled rental chillers 50 to 1500 TR.',
            'status' => 'published',
            'order' => 1,
            'is_indexable' => true,
        ]);

        $this->coolingService = Service::create([
            'title' => 'Rental Cooling',
            'slug' => 'rental-cooling',
            'summary' => 'Turnkey temporary cooling and chiller plant solutions.',
            'status' => 'published',
            'order' => 2,
            'is_indexable' => true,
        ]);

        $this->category = Category::create([
            'name' => 'Chiller Rental',
            'slug' => 'chiller-rental',
            'description' => 'Comprehensive engineering guides on industrial chiller rentals.',
        ]);
    }

    public function test_site_directory_renders_and_contains_all_services_categories_and_posts(): void
    {
        $post = Post::create([
            'user_id' => $this->author->id,
            'title' => 'Essential Sizing Guide for Chiller Rental in UAE',
            'slug' => 'essential-sizing-guide-for-chiller-rental-in-uae',
            'content' => '<p>Learn about temporary cooling engineering.</p>',
            'status' => 'published',
            'published_at' => now(),
            'is_indexable' => true,
        ]);
        $post->categories()->attach($this->category);

        $response = $this->get('/site-directory');

        $response->assertStatus(200);
        $response->assertSee('Site Directory &amp; Crawl Index', false);
        $response->assertSee('/services/rental-chiller-in-uae/');
        $response->assertSee('/services/rental-cooling/');
        $response->assertSee('/category/chiller-rental/');
        $response->assertSee('/essential-sizing-guide-for-chiller-rental-in-uae/');
        $response->assertSee('/sitemap_index.xml');
    }

    public function test_html_sitemap_aliases_redirect_301_to_site_directory(): void
    {
        $response1 = $this->get('/html-sitemap');
        $response1->assertStatus(301);
        $response1->assertRedirect('/site-directory/');

        $response2 = $this->get('/directory');
        $response2->assertStatus(301);
        $response2->assertRedirect('/site-directory/');
    }

    public function test_page_sitemap_xml_includes_site_directory(): void
    {
        $response = $this->get('/page-sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('/site-directory/');
    }

    public function test_blog_post_renders_contextual_auto_internal_links(): void
    {
        $post = Post::create([
            'user_id' => $this->author->id,
            'title' => 'Industrial Plant Temperature Management',
            'slug' => 'industrial-plant-temperature-management',
            'content' => '<p>When a facility requires rental chiller in uae for temporary operations, reliability is critical.</p>',
            'status' => 'published',
            'published_at' => now(),
            'is_indexable' => true,
        ]);
        $post->categories()->attach($this->category);

        $response = $this->get(route('post.show', $post->slug));

        $response->assertStatus(200);
        // The text 'rental chiller in uae' should be converted to a contextual hyperlink
        $response->assertSee('<a href="/services/rental-chiller-in-uae/"', false);
    }

    public function test_blog_post_renders_primary_service_solution_hub(): void
    {
        $post = Post::create([
            'user_id' => $this->author->id,
            'title' => 'Emergency Chiller Rental Troubleshooting',
            'slug' => 'emergency-chiller-rental-troubleshooting',
            'content' => '<p>Chiller operational instructions.</p>',
            'status' => 'published',
            'published_at' => now(),
            'is_indexable' => true,
        ]);
        $post->categories()->attach($this->category);

        $response = $this->get(route('post.show', $post->slug));

        $response->assertStatus(200);
        $response->assertSee('Official UAE Service Hub');
        $response->assertSee('Explore Rental Chiller in UAE');
        $response->assertSee('/services/rental-chiller-in-uae/');
    }

    public function test_global_footer_contains_all_services_and_site_directory_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('/services/rental-chiller-in-uae/');
        $response->assertSee('/services/rental-cooling/');
        $response->assertSee('/site-directory/');
        $response->assertSee('/sitemap_index.xml');
    }

    public function test_blog_archive_contains_category_navigation_pills(): void
    {
        $post = Post::create([
            'user_id' => $this->author->id,
            'title' => 'Category Archive Guide',
            'slug' => 'category-archive-guide',
            'content' => '<p>Category test guide.</p>',
            'status' => 'published',
            'published_at' => now(),
            'is_indexable' => true,
        ]);
        $post->categories()->attach($this->category);

        $response = $this->get(route('category.show', $this->category->slug));

        $response->assertStatus(200);
        $response->assertSee('Chiller Rental');
        $response->assertSee('/category/chiller-rental/');
        $response->assertSee('View All Services');
    }
}
