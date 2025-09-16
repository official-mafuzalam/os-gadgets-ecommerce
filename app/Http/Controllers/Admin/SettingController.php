<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
// If you have a helper, import it. Otherwise, use your Settings model or facade.
// Example for a helper function:
use function App\Helpers\setting;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = [
            'site_name' => setting('site_name', config('app.name')),
            'email' => setting('email', ''),
            'mobile' => setting('mobile', ''),
            'address' => setting('address', ''),
            'logo' => setting('logo', ''),
            'favicon' => setting('favicon', ''),
            'shipping_inside_dhaka' => setting('shipping_inside_dhaka', 80),
            'shipping_outside_dhaka' => setting('shipping_outside_dhaka', 150),
            'free_shipping_minimum' => setting('free_shipping_minimum', 0),
            'google_analytics' => setting('google_analytics', ''),
            'facebook_pixel' => setting('facebook_pixel', ''),
            'additional_tracking' => setting('additional_tracking', ''),
            'social_facebook' => setting('social_facebook', ''),
            'social_twitter' => setting('social_twitter', ''),
            'social_instagram' => setting('social_instagram', ''),
            'social_linkedin' => setting('social_linkedin', ''),
            'social_youtube' => setting('social_youtube', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
            'shipping_inside_dhaka' => 'required|numeric|min:0',
            'shipping_outside_dhaka' => 'required|numeric|min:0',
            'free_shipping_minimum' => 'required|numeric|min:0',
            'google_analytics' => 'nullable|string|max:255',
            'facebook_pixel' => 'nullable|string|max:255',
            'additional_tracking' => 'nullable|string',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            setting(['logo' => $logoPath]);
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            setting(['favicon' => $faviconPath]);
        }

        // Save other settings
        foreach ($validated as $key => $value) {
            if (!in_array($key, ['logo', 'favicon'])) {
                setting([$key => $value]);
            }
        }

        // Clear cache
        Cache::flush();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}