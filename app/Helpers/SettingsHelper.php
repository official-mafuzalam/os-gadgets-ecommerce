<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        // Use caching for better performance
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            return Setting::getValue($key, $default);
        });
    }
}