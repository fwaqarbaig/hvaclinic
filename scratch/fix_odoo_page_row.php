<?php

use App\Models\OdooPage;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$odoo = OdooPage::first();
if ($odoo) {
    $odoo->update([
        'contact_phone' => '+971 56 921 3754',
        'contact_email' => 'hello@generatordubai.com',
        'hero_subtitle' => 'Unify your Accounting, HR & WPS Payroll, CRM, Inventory, and Manufacturing into one intuitive platform. Fully pre-configured for UAE FTA 5% VAT, Central Bank WPS SIF files, and bilingual operations.',
        'meta_title' => 'Official Odoo Partner Dubai & UAE | Certified ERP Implementation',
        'meta_description' => 'Official Odoo Partner in UAE. Certified Odoo ERP implementation, FTA-compliant VAT accounting, UAE WPS payroll, and customization across Dubai & UAE.',
    ]);
    echo "Updated odoo_pages table row successfully.\n";
}
