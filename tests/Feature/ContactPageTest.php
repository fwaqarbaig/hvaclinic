<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders_successfully_with_recoverydata_architecture(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Technical Sizing &amp; Quote Intake', false);
        $response->assertSee('24/7 RAPID DISPATCH &amp; FREE TECHNICAL SIZING', false);
        $response->assertSee('+971 50 369 2131');
        $response->assertSee('info@hvaclinic.com');
        $response->assertSee('Dubai Central Hub');
        $response->assertSee('Abu Dhabi Industrial Hub');
        $response->assertSee('Northern Emirates Hub');
        $response->assertSee('HVACBusiness');
    }

    public function test_contact_us_redirects_to_contact_with_301(): void
    {
        $response = $this->get('/contact-us');

        $response->assertStatus(301);
        $response->assertRedirect('/contact/');
    }

    public function test_contact_form_submission_creates_inquiry_record(): void
    {
        $payload = [
            'name' => 'Eng. Tariq Al Nuaimi',
            'email' => 'tariq@mepconsultants.ae',
            'phone' => '+971 50 999 8877',
            'company' => 'Emaar Project Contractors',
            'subject' => 'Rental Chiller (Air-Cooled & Water-Cooled)',
            'emirate' => 'Dubai (All Districts)',
            'kva_capacity' => '300 TR',
            'message' => 'Need emergency 300 TR chiller replacement due to compressor ground fault in hotel plant room.',
            'pickup_requested' => 'yes',
        ];

        $response = $this->post('/contact', $payload);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('inquiries', [
            'name' => 'Eng. Tariq Al Nuaimi',
            'email' => 'tariq@mepconsultants.ae',
            'phone' => '+971 50 999 8877',
            'company' => 'Emaar Project Contractors',
            'subject' => 'Rental Chiller (Air-Cooled & Water-Cooled)',
        ]);

        $inquiry = Inquiry::where('email', 'tariq@mepconsultants.ae')->first();
        $this->assertNotNull($inquiry);
        $this->assertStringContainsString('Power Requirement: 300 TR', $inquiry->message);
        $this->assertStringContainsString('Location / Emirate: Dubai (All Districts)', $inquiry->message);
        $this->assertStringContainsString('Priority On-Site Site Inspection Requested', $inquiry->message);
    }

    public function test_contact_form_silent_honeypot_discards_bot_submissions(): void
    {
        $payload = [
            'name' => 'Spam Bot',
            'email' => 'spambot@marketing-spam.xyz',
            'message' => 'Spam link content',
            '_hp_website' => 'http://spam-link.xyz',
        ];

        $response = $this->post('/contact', $payload);

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('inquiries', [
            'email' => 'spambot@marketing-spam.xyz',
        ]);
    }
}
