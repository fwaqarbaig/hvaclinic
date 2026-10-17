<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::first();
Auth::login($user);

$controller = new DashboardController;
$request = Request::create('/admin', 'GET');
$response = $controller->index($request);
$html = $response->render();

$checks = [
    'Interactive Focus Keyword, Meta & Schema Code Studio' => 'Studio Heading',
    'id="studioFocusKeywordInput"' => 'Focus Keyword Input Field',
    'x-model="studio.focus_keyword"' => 'Focus Keyword Binding',
    'x-model="studio.meta_title"' => 'Meta Title Binding',
    'x-model="studio.meta_description"' => 'Meta Description Binding',
    'x-model="studio.schema_markup"' => 'Schema Markup Binding',
    'insertTemplate(\'service\')' => 'Service Template Button',
    'insertTemplate(\'article\')' => 'Article Template Button',
    'insertTemplate(\'faq\')' => 'FAQ Template Button',
    'insertTemplate(\'localbusiness\')' => 'LocalBusiness Template Button',
    'formatJson()' => 'Format JSON Button',
    'saveStudioSeo()' => 'Save Studio SEO Button',
    'function dashboardSeoStudio' => 'Studio JS Controller Function',
    'window.dashboardSeoStudio = dashboardSeoStudio' => 'Global Window Export',
];

echo "=== DASHBOARD HTML AUDIT ===\n";
foreach ($checks as $pattern => $label) {
    if (strpos($html, $pattern) !== false) {
        echo "PASS: [{$label}] found in dashboard output!\n";
    } else {
        echo "FAIL: [{$label}] NOT found!\n";
    }
}
