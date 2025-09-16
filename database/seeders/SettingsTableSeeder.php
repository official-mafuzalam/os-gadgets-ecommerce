<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // General Settings
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

            // Logo & Favicon
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

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => 'https://www.facebook.com/octosyncsoftwareltd',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Facebook URL',
                'order' => 1,
            ],
            [
                'key' => 'tiktok_url',
                'value' => 'https://www.tiktok.com/@official_mafuz',
                'type' => 'text',
                'group' => 'social',
                'label' => 'TikTok URL',
                'order' => 2,
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://www.instagram.com/official.mafuz.alam',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Instagram URL',
                'order' => 3,
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://www.youtube.com/@mafuzalam',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Youtube URL',
                'order' => 4,
            ],

            [
                'key' => 'whatsapp_number',
                'value' => '8801621833839', // Example Bangladeshi number
                'type' => 'text',
                'group' => 'social',
                'label' => 'WhatsApp Number',
                'order' => 5,
            ],
            [
                'key' => 'whatsapp_message',
                'value' => 'Hello! I have a question about your products.',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Default WhatsApp Message',
                'order' => 6,
            ],
            [
                'key' => 'whatsapp_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'social',
                'label' => 'Enable WhatsApp Button',
                'order' => 7,
            ],

            // Analytics
            [
                'key' => 'google_analytics_code',
                'value' => null,
                'type' => 'textarea',
                'group' => 'analytics',
                'label' => 'Google Analytics Code',
                'order' => 1,
            ],
            [
                'key' => 'facebook_pixel_code',
                'value' => null,
                'type' => 'textarea',
                'group' => 'analytics',
                'label' => 'Facebook Pixel Code',
                'order' => 2,
            ],

            // SEO
            [
                'key' => 'meta_description',
                'value' => 'Your premier destination for tech gadgets and electronics',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Meta Description',
                'order' => 1,
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'tech, gadgets, electronics, store',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Meta Keywords',
                'order' => 2,
            ],

            // Delivery Areas Charge
            [
                'key' => 'inside_dhaka_shipping_cost',
                'value' => '80',
                'type' => 'text',
                'group' => 'delivery',
                'label' => 'Inside Dhaka Shipping Cost (TK)',
                'order' => 1,
            ],
            [
                'key' => 'outside_dhaka_shipping_cost',
                'value' => '150',
                'type' => 'text',
                'group' => 'delivery',
                'label' => 'Outside Dhaka Shipping Cost (TK)',
                'order' => 2,
            ],
            [
                'key' => 'free_shipping_threshold',
                'value' => '2000',
                'type' => 'text',
                'group' => 'delivery',
                'label' => 'Free Shipping Threshold (TK)',
                'order' => 3,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}