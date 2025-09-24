<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
    public function clearCache()
    {
        // Clear application cache
        Artisan::call('cache:clear');
        // Clear route cache
        Artisan::call('route:clear');
        // Clear config cache
        Artisan::call('config:clear');
        // Clear view cache
        Artisan::call('view:clear');

        $exitCode = Artisan::call('optimize:clear');

        return redirect()->back()->with('success', 'Cache cleared successfully! ' . $exitCode);
    }

    public function freshDatabase()
    {
        $exitCode = Artisan::call('migrate:fresh');
        return to_route('public.welcome')->with('success', 'Database migrated successfully! ' . $exitCode);
    }

    public function freshDatabaseSeed()
    {
        $exitCode = Artisan::call('migrate:fresh --seed');
        return to_route('public.welcome')->with('success', 'Database migrated and seeded successfully! ' . $exitCode);
    }
}
