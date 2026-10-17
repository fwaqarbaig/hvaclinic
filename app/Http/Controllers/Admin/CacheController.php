<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    /**
     * Clear system, view, route, or application caches.
     */
    public function clear(Request $request): RedirectResponse
    {
        $type = $request->input('type', 'all');

        switch ($type) {
            case 'views':
                Artisan::call('view:clear');
                $message = 'Compiled Blade views cleared successfully.';
                break;

            case 'cache':
                Artisan::call('cache:clear');
                $message = 'Application data cache cleared successfully.';
                break;

            case 'routes':
                Artisan::call('route:clear');
                $message = 'Route cache cleared successfully.';
                break;

            case 'config':
                Artisan::call('config:clear');
                $message = 'Configuration cache cleared successfully.';
                break;

            case 'all':
            default:
                Artisan::call('view:clear');
                Artisan::call('cache:clear');
                Artisan::call('route:clear');
                Artisan::call('config:clear');
                $message = 'All system caches (views, application data, routes, and config) cleared successfully.';
                break;
        }

        return back()->with('success', $message);
    }
}
