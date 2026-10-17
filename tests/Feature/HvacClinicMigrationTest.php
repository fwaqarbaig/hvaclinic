<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use App\Models\RedirectRule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HvacClinicMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'name' => 'HVAC Clinic Admin',
            'email' => 'admin@hvaclinic.com',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_homepage_loads_with_hvac_clinic_branding_and_services(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('HVAC Clinic');
        $response->assertSee('Rental chillers');
        $response->assertSee('Rental AC');
        $response->assertSee('Temporary cooling');
        $response->assertSee('+971 50 369 2131');
    }

    public function test_wordpress_post_permalink_renders_with_schema_and_canonical(): void
    {
        $post = Post::create([
            'user_id' => $this->adminUser->id,
            'title' => 'Chiller Maintenance Best Practices in UAE',
            'slug' => 'chiller-maintenance-best-practices-in-uae',
            'content' => '<p>Industrial chillers require scheduled preventive servicing in desert climates.</p>',
            'excerpt' => 'Complete guide to chiller efficiency in high ambient temperatures.',
            'status' => 'published',
            'published_at' => now()->subDay(),
            'meta_title' => 'Chiller Maintenance Best Practices in UAE | HVAC Clinic',
            'meta_description' => 'Expert chiller maintenance guide for industrial facilities in UAE.',
            'canonical_url' => 'https://hvaclinic.com/chiller-maintenance-best-practices-in-uae/',
            'is_indexable' => true,
        ]);

        // Exact WordPress permalink at root slug
        $response = $this->get('/chiller-maintenance-best-practices-in-uae');
        $response->assertStatus(200);
        $response->assertSee('Chiller Maintenance Best Practices in UAE');
        $response->assertSee('rel="canonical" href="https://hvaclinic.com/chiller-maintenance-best-practices-in-uae/"', false);
        $response->assertSee('"@type": "Article"', false);
        $response->assertSee('"name": "HVAC Clinic"', false);

        // Legacy /post/ prefix 301-redirects to preserved permalink
        $redirectResponse = $this->get('/post/chiller-maintenance-best-practices-in-uae');
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect('/chiller-maintenance-best-practices-in-uae/');
    }

    public function test_nested_wordpress_service_page_resolves_cleanly(): void
    {
        $nestedPage = Page::create([
            'user_id' => $this->adminUser->id,
            'title' => 'Rental Chiller in Dubai',
            'slug' => 'services/rental-chiller-in-uae/rental-chiller-in-dubai',
            'content' => '<p>Emergency and commercial chiller rentals in Dubai.</p>',
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);

        $response = $this->get('/services/rental-chiller-in-uae/rental-chiller-in-dubai');
        $response->assertStatus(200);
        $response->assertSee('Rental Chiller in Dubai');
        $response->assertSee('Emergency and commercial chiller rentals in Dubai.');
    }

    public function test_yoast_matching_sitemaps_and_robots_txt_are_accessible(): void
    {
        // 1. Robots.txt
        $robotsResponse = $this->get('/robots.txt');
        $robotsResponse->assertStatus(200);
        $robotsResponse->assertSee('Sitemap: http://localhost:8000/sitemap_index.xml');

        // 2. Sitemap index
        $indexResponse = $this->get('/sitemap_index.xml');
        $indexResponse->assertStatus(200);
        $indexResponse->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $indexResponse->assertSee('<sitemapindex', false);
        $indexResponse->assertSee('/post-sitemap.xml');
        $indexResponse->assertSee('/page-sitemap.xml');
        $indexResponse->assertSee('/service-sitemap.xml');

        // 3. Post sub-sitemap
        Post::create([
            'user_id' => $this->adminUser->id,
            'title' => 'Sitemap Test Post',
            'slug' => 'sitemap-test-post',
            'content' => '<p>Post content</p>',
            'status' => 'published',
            'published_at' => now()->subHour(),
        ]);

        $postSitemap = $this->get('/post-sitemap.xml');
        $postSitemap->assertStatus(200);
        $postSitemap->assertSee('/sitemap-test-post/');
    }

    public function test_admin_can_view_sitemaps_dashboard_and_trigger_resubmission(): void
    {
        Http::fake([
            'https://www.google.com/ping*' => Http::response('OK', 200),
            'https://www.bing.com/ping*' => Http::response('OK', 200),
        ]);

        // Access sitemaps control center
        $response = $this->actingAs($this->adminUser)->get('/admin/sitemaps');
        $response->assertStatus(200);
        $response->assertSee('XML Sitemaps & Search Engine Indexing');
        $response->assertSee('/sitemap_index.xml');

        // Resubmit sitemaps
        $resubmitResponse = $this->actingAs($this->adminUser)->post('/admin/sitemaps/resubmit');
        $resubmitResponse->assertRedirect(route('admin.sitemaps.index'));
        $resubmitResponse->assertSessionHas('success');
    }

    public function test_admin_can_clear_all_application_caches(): void
    {
        Cache::put('test_key', 'test_value', 60);
        $this->assertEquals('test_value', Cache::get('test_key'));

        $response = $this->actingAs($this->adminUser)->post('/admin/cache/clear');
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertNull(Cache::get('test_key'));
    }

    public function test_redirect_rules_are_enforced_with_301_status(): void
    {
        RedirectRule::create([
            'source_url' => '/legacy-chiller-catalog',
            'target_url' => '/services/rental-chiller-in-uae',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $response = $this->get('/legacy-chiller-catalog');
        $response->assertStatus(301);
        $response->assertRedirect('http://localhost:8000/services/rental-chiller-in-uae');
    }
}
