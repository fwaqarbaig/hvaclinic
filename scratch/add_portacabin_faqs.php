<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

$porta = Service::where('slug', 'portacabin')->first();
if ($porta) {
    $existing = $porta->content;

    // Add structured FAQ section if not already present
    if (! str_contains($existing, 'Do you buy scrap portacabins across all UAE Emirates?')) {
        $faqsHtml = <<<'HTML'

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Used & Scrap Portacabins UAE</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you buy scrap portacabins across all UAE Emirates?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. We are the premier buyer of scrap and decommissioned portacabins in Dubai, Abu Dhabi, Sharjah, Ajman, RAK, and Fujairah. We buy damaged, rusted, fire-affected, or end-of-life cabins in any condition with instant cash payment.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can I sell my used site office portacabin in Dubai for instant cash?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. If your construction project is finished and you have surplus site offices, security cabins, mess halls, or ablution units, our evaluation team provides same-day on-site inspections and immediate cash or bank transfer payment before removal.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you provide crane dismantling and removal for scrap portacabins?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. We bring our own heavy hiab crane trucks, flatbeds, and certified rigging crews. We handle all unbolting, crane lifting, loading, and safe transport from your site, with zero logistical headache or expense for the seller.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What sizes and types of refurbished portacabins do you sell in UAE?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                We supply fully refurbished, high-grade modular cabins in popular dimensions: 6m x 3m (20ft x 10ft), 9m x 3m (30ft x 10ft), and 12m x 3.6m (40ft x 12ft). Each unit is fitted with heavy-duty structural steel frames, new sandwich panel insulation, commercial vinyl flooring, LED lighting, split AC units, and complete distribution boards ready for immediate occupancy.
            </div>
        </details>
    </div>
HTML;
        $porta->update([
            'content' => $existing.$faqsHtml,
        ]);
        echo "Updated portacabin with 4 focused FAQs!\n";
    }
}
