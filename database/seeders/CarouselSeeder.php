<?php

namespace Database\Seeders;

use App\Models\Carousel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carousel::firstOrCreate([
            'title' => 'Welcome to Our Website',
            'description' => 'Discover amazing content and features.',
            'image' => 'carousels/sample1.jpg',
            'button_text' => 'Learn More',
            'button_url' => 'https://example.com/learn-more',
            'secondary_button_text' => 'Get Started',
            'secondary_button_url' => 'https://example.com/get-started',
            'background_color' => 'gradient-to-r from-blue-900 to-indigo-800',
            'order' => 1,
            'is_active' => true,
        ]);

        Carousel::firstOrCreate([
            'title' => 'Join Our Community',
            'description' => 'Connect with like-minded individuals.',
            'image' => 'carousels/sample2.jpg',
            'button_text' => 'Sign Up',
            'button_url' => 'https://example.com/sign-up',
            'secondary_button_text' => 'Contact Us',
            'secondary_button_url' => 'https://example.com/contact',
            'background_color' => 'gradient-to-r from-indigo-900 to-purple-800',
            'order' => 2,
            'is_active' => true,
        ]);

        Carousel::firstOrCreate([
            'title' => 'Explore Our Services',
            'description' => 'We offer a wide range of solutions for your needs.',
            'image' => 'carousels/sample3.jpg',
            'button_text' => 'Our Services',
            'button_url' => 'https://example.com/services',
            'secondary_button_text' => 'Request a Quote',
            'secondary_button_url' => 'https://example.com/request-quote',
            'background_color' => 'gradient-to-r from-green-900 to-teal-800',
            'order' => 3,
            'is_active' => true,
        ]);


    }
}
