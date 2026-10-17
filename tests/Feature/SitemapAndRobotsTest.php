<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapAndRobotsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['role' => 'admin', 'slug' => 'hvaclinic']);

        // Seed sample service
        Service::create([
            'title' => 'Rental Chiller in UAE',
            'slug' => 'rental-chiller-in-uae',
            'status' => 'published',
            'order' => 1,
            'is_indexable' => true,
        ]);

        // Seed sample category
        $category = Category::create([
            'name' => 'HVAC Insights',
            'slug' => 'hvac-insights',
        ]);

        // Seed sample post
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'On-Demand Chiller Rental Services for UAE Businesses',
            'slug' => 'on-demand-chiller-rental-services-for-uae-businesses',
            'status' => 'published',
            'published_at' => now(),
            'is_indexable' => true,
        ]);
        $post->categories()->attach($category);

        // Seed sample page
        Page::create([
            'user_id' => $user->id,
            'title' => 'Temporary Cooling in UAE',
            'slug' => 'temporary-cooling-in-uae',
            'status' => 'published',
            'is_indexable' => true,
        ]);
    }

    public function test_master_sitemap_redirects_to_sitemap_index(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(301);
        $response->assertRedirect('/sitemap_index.xml');
    }

    public function test_sitemap_index_returns_valid_xml_index(): void
    {
        $response = $this->get('/sitemap_index.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $content = $response->getContent();

        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertStringContainsString('/post-sitemap.xml', $content);
        $this->assertStringContainsString('/page-sitemap.xml', $content);
        $this->assertStringContainsString('/service-sitemap.xml', $content);
        $this->assertStringContainsString('/category-sitemap.xml', $content);
        $this->assertStringContainsString('/author-sitemap.xml', $content);
    }

    public function test_posts_sitemap_returns_only_published_and_indexable_posts(): void
    {
        $user = User::first();
        Post::create([
            'user_id' => $user->id,
            'title' => 'Draft Post Should Not Be Listed',
            'slug' => 'draft-post-not-listed',
            'status' => 'draft',
            'is_indexable' => true,
        ]);

        Post::create([
            'user_id' => $user->id,
            'title' => 'NoIndex Post Should Not Be Listed',
            'slug' => 'noindex-post-not-listed',
            'status' => 'published',
            'published_at' => now(),
            'is_indexable' => false,
        ]);

        $response = $this->get('/post-sitemap.xml');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('/on-demand-chiller-rental-services-for-uae-businesses', $content);
        $this->assertStringNotContainsString('draft-post-not-listed', $content);
        $this->assertStringNotContainsString('noindex-post-not-listed', $content);
    }

    public function test_pages_sitemap_returns_core_routes_and_cms_pages(): void
    {
        $response = $this->get('/page-sitemap.xml');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('/temporary-cooling-in-uae', $content);
    }

    public function test_services_sitemap_returns_all_services(): void
    {
        $response = $this->get('/service-sitemap.xml');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('/services/rental-chiller-in-uae', $content);
    }

    public function test_robots_txt_returns_proper_directives_and_sitemap_urls(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Disallow: /admin', $content);
        $this->assertStringContainsString('Sitemap: ', $content);
        $this->assertStringContainsString('/sitemap_index.xml', $content);
    }

    public function test_admin_can_view_sitemaps_and_trigger_resubmit(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->get(route('admin.sitemaps.index'));
        $response->assertStatus(200);
        $response->assertSee('XML Sitemaps');
        $response->assertSee('Master Unified Sitemap');

        $resubmitResponse = $this->actingAs($admin)->post(route('admin.sitemaps.resubmit'));
        $resubmitResponse->assertRedirect();
        $resubmitResponse->assertSessionHas('success');
    }
}
