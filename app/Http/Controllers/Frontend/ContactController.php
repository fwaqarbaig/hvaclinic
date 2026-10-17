<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function show(): View
    {
        $page = Page::where('slug', 'contact')->first();

        return view('frontend.contact', compact('page'));
    }

    /**
     * Handle the contact form submission.
     */
    public function submit(Request $request): RedirectResponse
    {
        // 1. Silent Bot Honeypot: Discard automated spam bots cleanly
        if ($request->filled('_hp_website') || $request->filled('bot_check')) {
            return back()->with('success', 'Thank you for contacting HVAC Clinic. We have received your request.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'service' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:5000'],
            'kva_capacity' => ['nullable', 'string', 'max:100'],
            'emirate' => ['nullable', 'string', 'max:100'],
            'device_model' => ['nullable', 'string', 'max:255'],
            'pickup_requested' => ['nullable', 'string', 'max:20'],
            'type' => ['nullable', 'string', 'max:50'],
        ]);

        $messageParts = [];
        if (! empty($validated['kva_capacity'])) {
            $messageParts[] = 'Power Requirement: '.strip_tags($validated['kva_capacity']);
        }
        if (! empty($validated['emirate'])) {
            $messageParts[] = 'Location / Emirate: '.strip_tags($validated['emirate']);
        }
        if (! empty($validated['device_model'])) {
            $messageParts[] = 'Equipment Model / Asset: '.strip_tags($validated['device_model']);
        }
        if (! empty($validated['pickup_requested']) && in_array(strtolower($validated['pickup_requested']), ['yes', '1', 'true', 'on'])) {
            $messageParts[] = 'Service Request: Priority On-Site Site Inspection Requested';
        }
        if (! empty($validated['message'])) {
            $messageParts[] = 'Details / Scope: '.strip_tags($validated['message']);
        }

        $fullMessage = ! empty($messageParts) ? implode("\n\n", $messageParts) : (! empty($validated['message']) ? strip_tags($validated['message']) : null);

        $type = $validated['type'] ?? 'contact';
        if (empty($validated['type'])) {
            if (! empty($validated['kva_capacity']) || stripos($validated['subject'], 'quote') !== false || stripos($validated['subject'], 'generator') !== false) {
                $type = 'quote';
            } elseif (! empty($validated['device_model']) || stripos($validated['subject'], 'evaluation') !== false) {
                $type = 'evaluation';
            } elseif (stripos($validated['subject'], 'odoo') !== false) {
                $type = 'odoo_demo';
            } elseif (stripos($validated['subject'], 'demo') !== false) {
                $type = 'demo';
            }
        }

        $subject = ! empty($validated['subject'])
            ? strip_tags(trim($validated['subject']))
            : (! empty($validated['service']) ? 'Appointment Request: '.strip_tags(trim($validated['service'])) : 'General HVAC Inquiry');

        $email = ! empty($validated['email'])
            ? trim($validated['email'])
            : 'web-lead@hvaclinic.com';

        Inquiry::create([
            'name' => strip_tags(trim($validated['name'])),
            'email' => $email,
            'phone' => ! empty($validated['phone']) ? strip_tags(trim($validated['phone'])) : null,
            'company' => ! empty($validated['company']) ? strip_tags(trim($validated['company'])) : null,
            'subject' => $subject,
            'message' => $fullMessage,
            'type' => $type,
            'is_read' => false,
        ]);

        return back()->with('success', 'Thank you for contacting HVAC Clinic. Our team will get back to you shortly.');
    }
}
