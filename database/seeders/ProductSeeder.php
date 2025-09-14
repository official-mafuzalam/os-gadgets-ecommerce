<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get or create categories
        $smartphoneCategory = Category::firstOrCreate(
            ['name' => 'Smartphones'],
            [
                'slug' => 'smartphones',
                'description' => 'Latest smartphones and mobile devices'
            ]
        );

        $laptopCategory = Category::firstOrCreate(
            ['name' => 'Laptops'],
            [
                'slug' => 'laptops',
                'description' => 'Powerful computing laptops and notebooks'
            ]
        );

        $headphonesCategory = Category::firstOrCreate(
            ['name' => 'Headphones'],
            [
                'slug' => 'headphones',
                'description' => 'Audio headphones and earphones'
            ]
        );

        $smartwatchCategory = Category::firstOrCreate(
            ['name' => 'Smartwatches'],
            [
                'slug' => 'smartwatches',
                'description' => 'Wearable smart devices and fitness trackers'
            ]
        );

        $tabletCategory = Category::firstOrCreate(
            ['name' => 'Tablets'],
            [
                'slug' => 'tablets',
                'description' => 'Portable tablet devices'
            ]
        );

        // Get or create brands
        $apple = Brand::firstOrCreate(
            ['name' => 'Apple'],
            [
                'slug' => 'apple',
                'description' => 'Premium technology products'
            ]
        );

        $samsung = Brand::firstOrCreate(
            ['name' => 'Samsung'],
            [
                'slug' => 'samsung',
                'description' => 'Innovative electronics manufacturer'
            ]
        );

        $sony = Brand::firstOrCreate(
            ['name' => 'Sony'],
            [
                'slug' => 'sony',
                'description' => 'Japanese electronics conglomerate'
            ]
        );

        $dell = Brand::firstOrCreate(
            ['name' => 'Dell'],
            [
                'slug' => 'dell',
                'description' => 'Computer technology company'
            ]
        );

        $bose = Brand::firstOrCreate(
            ['name' => 'Bose'],
            [
                'slug' => 'bose',
                'description' => 'Audio equipment manufacturer'
            ]
        );

        $fitbit = Brand::firstOrCreate(
            ['name' => 'Fitbit'],
            [
                'slug' => 'fitbit',
                'description' => 'Fitness tracking devices'
            ]
        );

        $products = [
            // Smartphones
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'The most powerful iPhone with advanced camera system and A17 Pro chip.',
                'price' => 1199.99,
                'stock_quantity' => 50,
                'sku' => 'APP-IP15PM-256',
                'image' => 'products/iphone15.jpg',
                'category_id' => $smartphoneCategory->id,
                'brand_id' => $apple->id,
                'specifications' => [
                    'Display' => '6.7-inch Super Retina XDR',
                    'Chip' => 'A17 Pro',
                    'Storage' => '256GB',
                    'Camera' => '48MP Main, 12MP Ultra Wide, 12MP Telephoto',
                    'Battery' => 'Up to 29 hours video playback'
                ]
            ],
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'description' => 'Premium Android smartphone with S Pen and advanced camera capabilities.',
                'price' => 1099.99,
                'stock_quantity' => 45,
                'sku' => 'SAM-GS23U-256',
                'image' => 'products/s23ultra.jpg',
                'category_id' => $smartphoneCategory->id,
                'brand_id' => $samsung->id,
                'specifications' => [
                    'Display' => '6.8-inch Dynamic AMOLED 2X',
                    'Chip' => 'Snapdragon 8 Gen 2',
                    'Storage' => '256GB',
                    'Camera' => '200MP Main, 10MP Telephoto, 12MP Ultra Wide',
                    'Battery' => '5000mAh'
                ]
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Google\'s flagship phone with advanced AI features and camera software.',
                'price' => 899.99,
                'stock_quantity' => 30,
                'sku' => 'GOO-PX8P-128',
                'image' => 'products/pixel8pro.jpg',
                'category_id' => $smartphoneCategory->id,
                'brand_id' => Brand::firstOrCreate(['name' => 'Google', 'slug' => 'google'])->id,
                'specifications' => [
                    'Display' => '6.7-inch LTPO OLED',
                    'Chip' => 'Google Tensor G3',
                    'Storage' => '128GB',
                    'Camera' => '50MP Main, 48MP Ultra Wide, 48MP Telephoto',
                    'Battery' => '5050mAh'
                ]
            ],
            [
                'name' => 'OnePlus 11',
                'description' => 'Flagship killer with Hasselblad camera and fast charging.',
                'price' => 699.99,
                'stock_quantity' => 25,
                'sku' => 'OPL-OP11-256',
                'image' => 'products/oneplus11.jpg',
                'category_id' => $smartphoneCategory->id,
                'brand_id' => Brand::firstOrCreate(['name' => 'OnePlus', 'slug' => 'oneplus'])->id,
                'specifications' => [
                    'Display' => '6.7-inch Fluid AMOLED',
                    'Chip' => 'Snapdragon 8 Gen 2',
                    'Storage' => '256GB',
                    'Camera' => '50MP Main, 48MP Ultra Wide, 32MP Telephoto',
                    'Battery' => '5000mAh with 100W charging'
                ]
            ],

            // Laptops
            [
                'name' => 'MacBook Pro 16-inch',
                'description' => 'Professional laptop with M2 Pro chip for extreme performance.',
                'price' => 2499.99,
                'stock_quantity' => 20,
                'sku' => 'APP-MBP16-1TB',
                'image' => 'products/macbookpro16.jpg',
                'category_id' => $laptopCategory->id,
                'brand_id' => $apple->id,
                'specifications' => [
                    'Display' => '16.2-inch Liquid Retina XDR',
                    'Chip' => 'Apple M2 Pro',
                    'Storage' => '1TB SSD',
                    'RAM' => '16GB Unified Memory',
                    'Battery' => 'Up to 22 hours'
                ]
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Premium Windows laptop with stunning display and powerful performance.',
                'price' => 1699.99,
                'stock_quantity' => 18,
                'sku' => 'DEL-XPS15-512',
                'image' => 'products/dellxps15.jpg',
                'category_id' => $laptopCategory->id,
                'brand_id' => $dell->id,
                'specifications' => [
                    'Display' => '15.6-inch 4K UHD+',
                    'Processor' => 'Intel Core i7-13700H',
                    'Storage' => '512GB SSD',
                    'RAM' => '16GB DDR5',
                    'Graphics' => 'NVIDIA GeForce RTX 4050'
                ]
            ],
            [
                'name' => 'Microsoft Surface Laptop 5',
                'description' => 'Elegant Windows laptop with premium build quality and performance.',
                'price' => 1299.99,
                'stock_quantity' => 15,
                'sku' => 'MS-SL5-512',
                'image' => 'products/surfacelaptop5.jpg',
                'category_id' => $laptopCategory->id,
                'brand_id' => Brand::firstOrCreate(['name' => 'Microsoft', 'slug' => 'microsoft'])->id,
                'specifications' => [
                    'Display' => '13.5-inch PixelSense Touch',
                    'Processor' => 'Intel Core i5-1235U',
                    'Storage' => '512GB SSD',
                    'RAM' => '8GB LPDDR5',
                    'Battery' => 'Up to 18 hours'
                ]
            ],
            [
                'name' => 'ASUS ROG Zephyrus G14',
                'description' => 'Powerful gaming laptop with AMD Ryzen and NVIDIA graphics.',
                'price' => 1499.99,
                'stock_quantity' => 12,
                'sku' => 'ASU-ROG14-1TB',
                'image' => 'products/zephyrusg14.jpg',
                'category_id' => $laptopCategory->id,
                'brand_id' => Brand::firstOrCreate(['name' => 'ASUS', 'slug' => 'asus'])->id,
                'specifications' => [
                    'Display' => '14-inch QHD 165Hz',
                    'Processor' => 'AMD Ryzen 9 7940HS',
                    'Storage' => '1TB SSD',
                    'RAM' => '16GB DDR5',
                    'Graphics' => 'NVIDIA GeForce RTX 4060'
                ]
            ],

            // Headphones
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Industry-leading noise canceling headphones with exceptional sound quality.',
                'price' => 349.99,
                'stock_quantity' => 40,
                'sku' => 'SON-WH1000XM5',
                'image' => 'products/sonyxm5.jpg',
                'category_id' => $headphonesCategory->id,
                'brand_id' => $sony->id,
                'specifications' => [
                    'Type' => 'Over-ear wireless',
                    'Battery Life' => 'Up to 30 hours',
                    'Noise Canceling' => 'Industry-leading ANC',
                    'Connectivity' => 'Bluetooth 5.2',
                    'Features' => 'Touch controls, Speak-to-Chat'
                ]
            ],
            [
                'name' => 'Bose QuietComfort Ultra',
                'description' => 'Premium noise canceling headphones with immersive audio.',
                'price' => 429.99,
                'stock_quantity' => 35,
                'sku' => 'BOS-QCULTRA',
                'image' => 'products/boseqcultra.jpg',
                'category_id' => $headphonesCategory->id,
                'brand_id' => $bose->id,
                'specifications' => [
                    'Type' => 'Over-ear wireless',
                    'Battery Life' => 'Up to 24 hours',
                    'Noise Canceling' => 'Adaptive ANC',
                    'Connectivity' => 'Bluetooth 5.3',
                    'Features' => 'CustomTune sound calibration'
                ]
            ],
            [
                'name' => 'Apple AirPods Pro (2nd Gen)',
                'description' => 'Wireless earbuds with active noise cancellation and transparency mode.',
                'price' => 249.99,
                'stock_quantity' => 60,
                'sku' => 'APP-APP2',
                'image' => 'products/airpodspro2.jpg',
                'category_id' => $headphonesCategory->id,
                'brand_id' => $apple->id,
                'specifications' => [
                    'Type' => 'In-ear wireless',
                    'Battery Life' => 'Up to 6 hours (ANC on)',
                    'Noise Canceling' => 'Active Noise Cancellation',
                    'Connectivity' => 'Bluetooth 5.3',
                    'Features' => 'Adaptive Audio, Personalized Volume'
                ]
            ],
            [
                'name' => 'Samsung Galaxy Buds2 Pro',
                'description' => 'Premium wireless earbuds with intelligent ANC and 360 Audio.',
                'price' => 199.99,
                'stock_quantity' => 45,
                'sku' => 'SAM-GBUDS2P',
                'image' => 'products/galaxybuds2pro.jpg',
                'category_id' => $headphonesCategory->id,
                'brand_id' => $samsung->id,
                'specifications' => [
                    'Type' => 'In-ear wireless',
                    'Battery Life' => 'Up to 8 hours (ANC on)',
                    'Noise Canceling' => 'Intelligent ANC',
                    'Connectivity' => 'Bluetooth 5.3',
                    'Features' => '360 Audio, Auto Switch'
                ]
            ],

            // Smartwatches
            [
                'name' => 'Apple Watch Series 9',
                'description' => 'Advanced smartwatch with health features and powerful apps.',
                'price' => 399.99,
                'stock_quantity' => 30,
                'sku' => 'APP-AW9-45',
                'image' => 'products/applewatch9.jpg',
                'category_id' => $smartwatchCategory->id,
                'brand_id' => $apple->id,
                'specifications' => [
                    'Display' => '45mm Retina LTPO OLED',
                    'Chip' => 'S9 SiP',
                    'Storage' => '64GB',
                    'Features' => 'ECG, Blood Oxygen, Always-On Display',
                    'Battery Life' => 'Up to 18 hours'
                ]
            ],
            [
                'name' => 'Samsung Galaxy Watch 6 Classic',
                'description' => 'Premium smartwatch with rotating bezel and comprehensive health tracking.',
                'price' => 369.99,
                'stock_quantity' => 25,
                'sku' => 'SAM-GW6C-47',
                'image' => 'products/galaxywatch6.jpg',
                'category_id' => $smartwatchCategory->id,
                'brand_id' => $samsung->id,
                'specifications' => [
                    'Display' => '47mm Super AMOLED',
                    'Processor' => 'Exynos W930',
                    'Storage' => '16GB',
                    'Features' => 'ECG, BIA, Sleep Coaching',
                    'Battery Life' => 'Up to 40 hours'
                ]
            ],
            [
                'name' => 'Fitbit Sense 2',
                'description' => 'Advanced health smartwatch with stress management tools.',
                'price' => 299.99,
                'stock_quantity' => 20,
                'sku' => 'FIT-SENSE2',
                'image' => 'products/fitbitsense2.jpg',
                'category_id' => $smartwatchCategory->id,
                'brand_id' => $fitbit->id,
                'specifications' => [
                    'Display' => '1.58-inch AMOLED',
                    'Battery Life' => '6+ days',
                    'Features' => 'EDA sensor, ECG app, Skin Temperature',
                    'Compatibility' => 'Android and iOS',
                    'GPS' => 'Built-in'
                ]
            ],
            [
                'name' => 'Garmin Forerunner 965',
                'description' => 'Premium GPS running smartwatch with advanced training metrics.',
                'price' => 599.99,
                'stock_quantity' => 15,
                'sku' => 'GAR-FR965',
                'image' => 'products/garmin965.jpg',
                'category_id' => $smartwatchCategory->id,
                'brand_id' => Brand::firstOrCreate(['name' => 'Garmin', 'slug' => 'garmin'])->id,
                'specifications' => [
                    'Display' => '1.4-inch AMOLED',
                    'Battery Life' => 'Up to 23 days (smartwatch mode)',
                    'Features' => 'Multi-band GPS, Training Readiness, Morning Report',
                    'Sports Apps' => 'Running, Cycling, Swimming, Triathlon'
                ]
            ],

            // Tablets
            [
                'name' => 'iPad Pro 12.9-inch',
                'description' => 'Professional tablet with M2 chip and Liquid Retina XDR display.',
                'price' => 1099.99,
                'stock_quantity' => 22,
                'sku' => 'APP-IPADP129-256',
                'image' => 'products/ipadpro129.jpg',
                'category_id' => $tabletCategory->id,
                'brand_id' => $apple->id,
                'specifications' => [
                    'Display' => '12.9-inch Liquid Retina XDR',
                    'Chip' => 'Apple M2',
                    'Storage' => '256GB',
                    'Camera' => '12MP Wide, 10MP Ultra Wide',
                    'Features' => 'Face ID, Thunderbolt/USB-C'
                ]
            ],
            [
                'name' => 'Samsung Galaxy Tab S9 Ultra',
                'description' => 'Premium Android tablet with massive screen and S Pen included.',
                'price' => 1199.99,
                'stock_quantity' => 18,
                'sku' => 'SAM-GTS9U-512',
                'image' => 'products/tabs9ultra.jpg',
                'category_id' => $tabletCategory->id,
                'brand_id' => $samsung->id,
                'specifications' => [
                    'Display' => '14.6-inch Dynamic AMOLED 2X',
                    'Processor' => 'Snapdragon 8 Gen 2',
                    'Storage' => '512GB',
                    'RAM' => '12GB',
                    'Features' => 'S Pen included, IP68 rating'
                ]
            ],
            [
                'name' => 'Microsoft Surface Pro 9',
                'description' => 'Versatile 2-in-1 tablet that replaces your laptop.',
                'price' => 1299.99,
                'stock_quantity' => 16,
                'sku' => 'MS-SP9-I7',
                'image' => 'products/surfacepro9.jpg',
                'category_id' => $tabletCategory->id,
                'brand_id' => Brand::firstOrCreate(['name' => 'Microsoft', 'slug' => 'microsoft'])->id,
                'specifications' => [
                    'Display' => '13-inch PixelSense Flow',
                    'Processor' => 'Intel Core i7-1255U',
                    'Storage' => '256GB SSD',
                    'RAM' => '16GB LPDDR5',
                    'Features' => 'Windows 11, Surface Pen compatible'
                ]
            ],
            [
                'name' => 'Google Pixel Tablet',
                'description' => 'Smart tablet with charging speaker dock that transforms into a smart display.',
                'price' => 499.99,
                'stock_quantity' => 28,
                'sku' => 'GOO-PT-128',
                'image' => 'products/pixeltablet.jpg',
                'category_id' => $tabletCategory->id,
                'brand_id' => Brand::firstOrCreate(['name' => 'Google', 'slug' => 'google'])->id,
                'specifications' => [
                    'Display' => '11-inch LCD',
                    'Processor' => 'Google Tensor G2',
                    'Storage' => '128GB',
                    'RAM' => '8GB',
                    'Features' => 'Charging Speaker Dock, Hub Mode'
                ]
            ]
        ];

        foreach ($products as $productData) {
            // Set default values
            $productData['is_active'] = true;
            $productData['image_gallery'] = [$productData['image']];

            // Create the product
            Product::create($productData);
        }
    }
}