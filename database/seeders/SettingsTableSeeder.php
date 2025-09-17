<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        // --------------------
        // API Settings (dynamic)
        // --------------------
        $apis = [
            'openai' => [
                'key' => env('OPENAI_API_KEY', null),
                'enabled' => true,
                'model' => 'gpt-3.5-turbo',
            ],
            'mistral' => [
                'key' => env('MISTRAL_API_KEY', null),
                'enabled' => false,
                'model' => 'open-mistral-8x22b',
            ],
            'deepseek' => [
                'key' => env('DEEPSEEK_API_KEY', null),
                'enabled' => false,
                'model' => 'deepseek-chat',
            ],
            'gemini' => [
                'key' => env('GOOGLE_API_KEY', null),
                'enabled' => false,
                'model' => 'gemini-1.5-pro',
            ],
        ];

        foreach ($apis as $apiName => $config) {
            foreach ($config as $configKey => $configValue) {
                Setting::updateOrCreate(
                    [
                        'key' => "api_{$apiName}_{$configKey}",
                        'group' => 'apis',
                    ],
                    [
                        'value' => is_bool($configValue) ? ($configValue ? '1' : '0') : $configValue,
                        'type' => is_bool($configValue) ? 'boolean' : 'text',
                        'label' => ucfirst($apiName) . ' ' . ucfirst(str_replace('_', ' ', $configKey)),
                        'order' => 0,
                    ]
                );
            }
        }

        // --------------------
        // General Settings
        // --------------------
        $generalSettings = [
            [
                'key' => 'site_name',
                'value' => 'Octosync Software',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'order' => 1,
            ],
            [
                'key' => 'site_email',
                'value' => 'info@octosyncsoftware.com',
                'type' => 'email',
                'group' => 'general',
                'label' => 'Site Email',
                'order' => 2,
            ],
            [
                'key' => 'site_phone',
                'value' => '+8801621833839',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Phone Number',
                'order' => 3,
            ],
            [
                'key' => 'site_address',
                'value' => 'Hemayetpur, Savar, Dhaka',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Address',
                'order' => 4,
            ],
        ];

        foreach ($generalSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Branding Settings
        // --------------------
        $brandingSettings = [
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'branding',
                'label' => 'Site Logo',
                'order' => 1,
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'branding',
                'label' => 'Favicon',
                'order' => 2,
            ],
        ];

        foreach ($brandingSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Social Media
        // --------------------
        $socialSettings = [
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/octosyncsoftwareltd', 'type' => 'text', 'group' => 'social', 'label' => 'Facebook URL', 'order' => 1],
            ['key' => 'tiktok_url', 'value' => 'https://www.tiktok.com/@official_mafuz', 'type' => 'text', 'group' => 'social', 'label' => 'TikTok URL', 'order' => 2],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/official.mafuz.alam', 'type' => 'text', 'group' => 'social', 'label' => 'Instagram URL', 'order' => 3],
            ['key' => 'youtube_url', 'value' => 'https://www.youtube.com/@mafuzalam', 'type' => 'text', 'group' => 'social', 'label' => 'Youtube URL', 'order' => 4],
            ['key' => 'whatsapp_number', 'value' => '8801621833839', 'type' => 'text', 'group' => 'social', 'label' => 'WhatsApp Number', 'order' => 5],
            ['key' => 'whatsapp_message', 'value' => 'Hello! I have a question about your products.', 'type' => 'text', 'group' => 'social', 'label' => 'Default WhatsApp Message', 'order' => 6],
            ['key' => 'whatsapp_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'social', 'label' => 'Enable WhatsApp Button', 'order' => 7],
        ];

        foreach ($socialSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Analytics
        // --------------------
        $analyticsSettings = [
            ['key' => 'google_analytics_code', 'value' => null, 'type' => 'textarea', 'group' => 'analytics', 'label' => 'Google Analytics Code', 'order' => 1],
            ['key' => 'facebook_pixel_code', 'value' => null, 'type' => 'textarea', 'group' => 'analytics', 'label' => 'Facebook Pixel Code', 'order' => 2],
        ];

        foreach ($analyticsSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // SEO
        // --------------------
        $seoSettings = [
            ['key' => 'meta_description', 'value' => 'Your premier destination for tech gadgets and electronics', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Description', 'order' => 1],
            ['key' => 'meta_keywords', 'value' => 'tech, gadgets, electronics, store', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Keywords', 'order' => 2],
        ];

        foreach ($seoSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // --------------------
        // Delivery
        // --------------------
        $deliverySettings = [
            ['key' => 'inside_dhaka_shipping_cost', 'value' => '80', 'type' => 'text', 'group' => 'delivery', 'label' => 'Inside Dhaka Shipping Cost (TK)', 'order' => 1],
            ['key' => 'outside_dhaka_shipping_cost', 'value' => '150', 'type' => 'text', 'group' => 'delivery', 'label' => 'Outside Dhaka Shipping Cost (TK)', 'order' => 2],
            ['key' => 'free_shipping_threshold', 'value' => '2000', 'type' => 'text', 'group' => 'delivery', 'label' => 'Free Shipping Threshold (TK)', 'order' => 3],
        ];

        foreach ($deliverySettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }
    }
}
