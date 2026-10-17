<?php

use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OdooController as AdminOdooController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SitemapAdminController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ContentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OdooController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [ContentController::class, 'show'])->defaults('path', 'about')->name('about');
Route::redirect('/about-us', '/about/', 301);

// Official Odoo UAE Partner Landing Page
Route::get('/odoo', [OdooController::class, 'index'])->name('odoo.index');

// Former fleet routes redirect to the matching used and refurbished equipment hub.
Route::redirect('/fleet', '/used-refurbished-equipment-in-uae/', 301)->name('fleet.index');
Route::redirect('/fleet/{slug}', '/used-refurbished-equipment-in-uae/', 301)->name('fleet.show');
Route::redirect('/products', '/used-refurbished-equipment-in-uae/', 301)->name('product.index');
Route::redirect('/product/{slug}', '/used-refurbished-equipment-in-uae/', 301)->name('product.show');
Route::redirect('/products/{slug}', '/used-refurbished-equipment-in-uae/', 301);

// WordPress service pages use nested /services/... permalinks.
Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
Route::get('/services/{path}', [ContentController::class, 'showService'])->where('path', '.*')->name('service.show');
Route::redirect('/service/{slug}', '/services/{slug}/', 301);

// Former generator-specific landings redirect to the closest HVAC Clinic hub.
Route::redirect('/industries', '/services/', 301)->name('page.industries');
Route::redirect('/used-refurbished-generators', '/used-refurbished-equipment-in-uae/', 301)->name('page.used-generators');
Route::redirect('/used-generators', '/used-refurbished-equipment-in-uae/', 301);
Route::redirect('/locations', '/services/', 301)->name('locations.index');
Route::redirect('/locations/dubai', '/services/rental-chiller-in-uae/rental-chiller-in-dubai/', 301);
Route::redirect('/locations/abu-dhabi', '/services/rental-chiller-in-uae/rental-chiller-in-abu-dhabi/', 301);
Route::redirect('/locations/sharjah', '/services/rental-chiller-in-uae/rental-chiller-in-sharjah/', 301);
Route::redirect('/rental-chiller-in-dubai', '/services/rental-chiller-in-uae/rental-chiller-in-dubai/', 301);
Route::redirect('/rental-chiller-in-abu-dhabi', '/services/rental-chiller-in-uae/rental-chiller-in-abu-dhabi/', 301);
Route::redirect('/rental-chiller-in-sharjah', '/services/rental-chiller-in-uae/rental-chiller-in-sharjah/', 301);
Route::redirect('/locations/{city}', '/services/rental-chiller-in-uae/', 301)->name('locations.show');

// Blog & Content Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::redirect('/blogs', '/blog/', 301);
Route::redirect('/post/{slug}', '/{slug}/', 301)->name('post.legacy');

Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category.show');
Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('tag.show');
Route::get('/author/{slug}', [BlogController::class, 'author'])->name('author.show');
Route::redirect('/page/{slug}', '/{slug}/', 301)->where('slug', '.*')->name('page.show');

// Contact keeps the source website's /contact/ URL.
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::redirect('/contact-us', '/contact/', 301);
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit')->middleware('throttle:10,1');
Route::post('/contact-us', [ContactController::class, 'submit'])->middleware('throttle:10,1');

// HTML Site Directory & Search Engine Crawl Hub
Route::get('/site-directory', [SitemapController::class, 'siteDirectory'])->name('site.directory');
Route::redirect('/html-sitemap', '/site-directory/', 301);
Route::redirect('/directory', '/site-directory/', 301);

// XML Sitemaps (Canonical Sitemap Index & Section Sitemaps)
Route::redirect('/sitemap.xml', '/sitemap_index.xml', 301)->name('sitemap');
Route::redirect('/sitemap-index.xml', '/sitemap_index.xml', 301);
Route::get('/sitemap_index.xml', [SitemapController::class, 'sitemapIndex'])->name('sitemap.index');
Route::get('/sitemap-products.xml', [SitemapController::class, 'products'])->name('sitemap.products');
Route::get('/product-sitemap.xml', [SitemapController::class, 'products']);
Route::get('/sitemap-posts.xml', [SitemapController::class, 'posts'])->name('sitemap.posts');
Route::get('/post-sitemap.xml', [SitemapController::class, 'posts']);
Route::get('/sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/page-sitemap.xml', [SitemapController::class, 'pages']);
Route::get('/sitemap-categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');
Route::get('/category-sitemap.xml', [SitemapController::class, 'categories']);
Route::get('/sitemap-authors.xml', [SitemapController::class, 'authors'])->name('sitemap.authors');
Route::get('/author-sitemap.xml', [SitemapController::class, 'authors']);
Route::get('/sitemap-services.xml', [SitemapController::class, 'services'])->name('sitemap.services');
Route::get('/service-sitemap.xml', [SitemapController::class, 'services']);

// Robots.txt
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:10,1');
});

// Public registration is disabled: new users can only be created by an Admin from the User Dashboard
Route::redirect('/register', '/login', 302);

// Google Two-Factor Authentication Flow
Route::get('/login/two-factor', [TwoFactorController::class, 'showChallenge'])->name('login.two-factor');
Route::post('/login/two-factor', [TwoFactorController::class, 'verifyChallenge'])->middleware('throttle:10,1');
Route::get('/login/two-factor-setup', [TwoFactorController::class, 'showSetup'])->name('login.two-factor.setup');
Route::post('/login/two-factor-setup', [TwoFactorController::class, 'confirmSetup'])->middleware('throttle:10,1');
Route::post('/login/two-factor/cancel', [TwoFactorController::class, 'cancel'])->name('login.two-factor.cancel');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'two_factor', 'content.manager'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Quick Draft
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/quick-draft', [DashboardController::class, 'quickDraft'])->name('quick-draft');

    // Odoo Partner Page Management (New)
    Route::get('/odoo', [AdminOdooController::class, 'edit'])->name('odoo.edit');
    Route::put('/odoo', [AdminOdooController::class, 'update'])->name('odoo.update');

    // Products Management (New)
    Route::resource('products', AdminProductController::class)->except(['show']);

    // Services Management (New)
    Route::patch('/services/{service}/quick-seo', [AdminServiceController::class, 'quickSeo'])->name('services.quick-seo');
    Route::resource('services', AdminServiceController::class)->except(['show']);

    // Leads & Client Inquiries (New)
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}/toggle-read', [InquiryController::class, 'toggleRead'])->name('inquiries.toggle-read');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Posts Management
    Route::patch('/posts/{post}/quick-seo', [PostController::class, 'quickSeo'])->name('posts.quick-seo');
    Route::resource('posts', PostController::class)->except(['show']);

    // Categories Management
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);

    // Tags Management
    Route::resource('tags', TagController::class)->except(['create', 'show', 'edit']);

    // Pages Management
    Route::patch('/pages/{page}/quick-seo', [AdminPageController::class, 'quickSeo'])->name('pages.quick-seo');
    Route::resource('pages', AdminPageController::class)->except(['show']);

    // Navigation Menus Management
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::patch('/menus/{menu}/toggle-active', [MenuController::class, 'toggleActive'])->name('menus.toggle-active');
    Route::post('/menus/{menu}/move-up', [MenuController::class, 'moveUp'])->name('menus.move-up');
    Route::post('/menus/{menu}/move-down', [MenuController::class, 'moveDown'])->name('menus.move-down');
    Route::post('/menus/reset-defaults', [MenuController::class, 'resetDefaults'])->name('menus.reset-defaults');

    // 301 & URL Redirection Management (WordPress-style, High Performance)
    Route::get('/redirects', [RedirectController::class, 'index'])->name('redirects.index');
    Route::post('/redirects', [RedirectController::class, 'store'])->name('redirects.store');
    Route::put('/redirects/{redirect}', [RedirectController::class, 'update'])->name('redirects.update');
    Route::delete('/redirects/{redirect}', [RedirectController::class, 'destroy'])->name('redirects.destroy');
    Route::patch('/redirects/{redirect}/toggle', [RedirectController::class, 'toggle'])->name('redirects.toggle');
    Route::post('/redirects/{redirect}/reset-hits', [RedirectController::class, 'resetHits'])->name('redirects.reset-hits');
    Route::post('/redirects/bulk', [RedirectController::class, 'bulk'])->name('redirects.bulk');
    Route::post('/redirects/test', [RedirectController::class, 'test'])->name('redirects.test');
    Route::get('/redirects/export', [RedirectController::class, 'exportCsv'])->name('redirects.export');
    Route::post('/redirects/import', [RedirectController::class, 'importCsv'])->name('redirects.import');
    Route::post('/redirects/seed-defaults', [RedirectController::class, 'seedDefaults'])->name('redirects.seed-defaults');

    // Media Library
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::put('/media/{medium}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::get('/media-modal-list', [MediaController::class, 'modalList'])->name('media.modal-list');

    // User Profile & Two-Factor Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/two-factor/recovery-codes', [ProfileController::class, 'regenerateRecoveryCodes'])->name('profile.two-factor.recovery-codes');
    Route::post('/profile/two-factor/reset', [ProfileController::class, 'resetTwoFactor'])->name('profile.two-factor.reset');

    // System Cache Management
    Route::post('/cache/clear', [CacheController::class, 'clear'])->name('cache.clear');

    // XML Sitemaps & Search Engine Resubmission
    Route::get('/sitemaps', [SitemapAdminController::class, 'index'])->name('sitemaps.index');
    Route::post('/sitemaps/resubmit', [SitemapAdminController::class, 'resubmit'])->name('sitemaps.resubmit');

    // Administrator Only: User Management
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});

// Direct public storage fallback route (serves and mirrors media if web server forwards to Laravel)
Route::get('/storage/{path}', [MediaController::class, 'servePublicStorage'])
    ->where('path', '.*')
    ->name('storage.serve');

/*
|--------------------------------------------------------------------------
| Dynamic Slug Resolution (Matching WordPress Permalinks)
|--------------------------------------------------------------------------
*/
Route::get('/{path}', [ContentController::class, 'show'])
    ->where('path', '[a-zA-Z0-9/_\-]+')
    ->name('post.show');
