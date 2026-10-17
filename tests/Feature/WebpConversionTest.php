<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use App\Services\WebpConverter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WebpConversionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_webp_converter_detection_logic(): void
    {
        $this->assertTrue(WebpConverter::canConvert('image/jpeg', 'jpg'));
        $this->assertTrue(WebpConverter::canConvert('image/png', 'png'));
        $this->assertTrue(WebpConverter::canConvert('image/bmp', 'bmp'));
        $this->assertTrue(WebpConverter::canConvert('image/gif', 'gif'));

        // SVGs and PDFs should not be converted to WebP
        $this->assertFalse(WebpConverter::canConvert('application/pdf', 'pdf'));
        $this->assertFalse(WebpConverter::canConvert('text/plain', 'txt'));
    }

    public function test_media_upload_automatically_converts_jpg_to_webp(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('hvac-cooling-unit.jpg', 800, 600);

        $response = $this->actingAs($admin)
            ->post(route('admin.media.store'), [
                'file' => $file,
            ], ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $media = Media::latest()->first();
        $this->assertNotNull($media);
        $this->assertStringEndsWith('.webp', $media->file_name);
        $this->assertEquals('image/webp', $media->mime_type);
        $this->assertStringEndsWith('.webp', $media->file_path);
        $this->assertStringEndsWith('.webp', $media->url);

        // Verify storage file exists and is WebP
        Storage::disk('public')->assertExists($media->file_path);
    }

    public function test_media_upload_automatically_converts_png_to_webp(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('generator-schematic.png', 500, 500);

        $response = $this->actingAs($admin)
            ->post(route('admin.media.store'), [
                'files' => [$file],
            ], ['Accept' => 'application/json']);

        $response->assertStatus(200);

        $media = Media::latest()->first();
        $this->assertNotNull($media);
        $this->assertStringEndsWith('.webp', $media->file_name);
        $this->assertEquals('image/webp', $media->mime_type);
        Storage::disk('public')->assertExists($media->file_path);
    }

    public function test_media_upload_does_not_convert_pdf(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->create('technical-catalog.pdf', 150, 'application/pdf');

        $response = $this->actingAs($admin)
            ->post(route('admin.media.store'), [
                'file' => $file,
            ], ['Accept' => 'application/json']);

        $response->assertStatus(200);

        $media = Media::latest()->first();
        $this->assertNotNull($media);
        $this->assertStringEndsWith('.pdf', $media->file_name);
        $this->assertEquals('application/pdf', $media->mime_type);
        Storage::disk('public')->assertExists($media->file_path);
    }

    public function test_post_creation_with_direct_featured_image_file_converts_to_webp(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $image = UploadedFile::fake()->image('post-banner.jpg', 1200, 630);

        $response = $this->actingAs($admin)
            ->post(route('admin.posts.store'), [
                'title' => 'Chiller Maintenance Best Practices Dubai',
                'status' => 'published',
                'featured_image_file' => $image,
            ]);

        $post = Post::where('title', 'Chiller Maintenance Best Practices Dubai')->first();
        $this->assertNotNull($post);
        $this->assertNotNull($post->featured_image);
        $this->assertStringEndsWith('.webp', $post->featured_image);

        $media = Media::latest()->first();
        $this->assertNotNull($media);
        $this->assertStringEndsWith('.webp', $media->file_name);
        $this->assertEquals('image/webp', $media->mime_type);
        Storage::disk('public')->assertExists($media->file_path);
    }

    public function test_service_creation_with_direct_featured_image_file_converts_to_webp(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $image = UploadedFile::fake()->image('rental-cooling-service.png', 800, 600);

        $response = $this->actingAs($admin)
            ->post(route('admin.services.store'), [
                'title' => 'Emergency Rental Cooling Dubai',
                'status' => 'published',
                'featured_image_file' => $image,
            ]);

        $service = Service::where('title', 'Emergency Rental Cooling Dubai')->first();
        $this->assertNotNull($service);
        $this->assertNotNull($service->featured_image);
        $this->assertStringEndsWith('.webp', $service->featured_image);

        $media = Media::latest()->first();
        $this->assertNotNull($media);
        $this->assertStringEndsWith('.webp', $media->file_name);
        $this->assertEquals('image/webp', $media->mime_type);
        Storage::disk('public')->assertExists($media->file_path);
    }

    public function test_public_storage_fallback_route_serves_image(): void
    {
        Storage::disk('public')->put('uploads/test-image.webp', 'fake-binary-data');

        $response = $this->get('/storage/uploads/test-image.webp');

        $response->assertStatus(200);
        $this->assertEquals('fake-binary-data', $response->streamedContent());
    }

    public function test_public_storage_fallback_route_returns_404_for_missing_file(): void
    {
        $response = $this->get('/storage/uploads/non-existent-image-12345.webp');

        $response->assertStatus(404);
    }

    public function test_media_destroy_deletes_record_and_file(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        Storage::disk('public')->put('uploads/delete-me.webp', 'fake-binary-data');

        $media = Media::create([
            'name' => 'delete-me',
            'file_name' => 'delete-me.webp',
            'file_path' => 'uploads/delete-me.webp',
            'disk' => 'public',
            'mime_type' => 'image/webp',
            'size' => 100,
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.media.destroy', $media), [], ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('media', ['id' => $media->id]);
        Storage::disk('public')->assertMissing('uploads/delete-me.webp');
    }

    public function test_media_modal_list_returns_json_items_with_url(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $media = Media::create([
            'name' => 'sample-chiller',
            'file_name' => 'sample-chiller.webp',
            'file_path' => 'uploads/sample-chiller.webp',
            'disk' => 'public',
            'mime_type' => 'image/webp',
            'size' => 1234,
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.media.modal-list'));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'sample-chiller',
            'url' => '/storage/uploads/sample-chiller.webp',
        ]);
    }
}
