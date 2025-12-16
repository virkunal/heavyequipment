<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BoomLiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePaths = [];
        $imageDirectory = storage_path('app/public/boom-lifts');

        if (is_dir($imageDirectory)) {
            $files = glob($imageDirectory.'/boom-lift-*.jpg');
            foreach ($files as $file) {
                $imagePaths[] = 'boom-lifts/'.basename($file);
            }
        }

        $boomLifts = [
            [
                'name' => 'Genie S-85 Boom Lift',
                'model' => 'S-85',
                'description' => 'High-reach boom lift with 85-foot working height, perfect for construction and maintenance projects.',
                'specifications' => [
                    'max_height' => 85,
                    'platform_capacity' => 227,
                    'outreach' => 44,
                    'weight' => '5,443 Kg',
                ],
                'hourly_rate' => 125.00,
                'daily_rate' => 850.00,
                'monthly_rate' => 15000.00,
                'is_available' => true,
                'image' => $imagePaths[0] ?? null,
            ],
            [
                'name' => 'JLG 800S Boom Lift',
                'model' => '800S',
                'description' => 'Compact boom lift with 80-foot working height. Ideal for tight spaces and indoor work.',
                'specifications' => [
                    'max_height' => 80,
                    'platform_capacity' => 227,
                    'outreach' => 43,
                    'weight' => '5,080 Kg',
                ],
                'hourly_rate' => 115.00,
                'daily_rate' => 800.00,
                'monthly_rate' => 14000.00,
                'is_available' => true,
                'image' => $imagePaths[1] ?? null,
            ],
            [
                'name' => 'Skyjack SJ9250 Articulating Boom',
                'model' => 'SJ9250',
                'description' => 'Articulating boom lift with 92-foot working height and excellent maneuverability.',
                'specifications' => [
                    'max_height' => 92,
                    'platform_capacity' => 227,
                    'outreach' => 49,
                    'weight' => '6,124 Kg',
                ],
                'hourly_rate' => 145.00,
                'daily_rate' => 950.00,
                'monthly_rate' => 17000.00,
                'is_available' => true,
                'image' => $imagePaths[2] ?? null,
            ],
            [
                'name' => 'Genie Z-60 Articulated Boom',
                'model' => 'Z-60',
                'description' => 'Compact articulated boom lift perfect for indoor applications and tight spaces.',
                'specifications' => [
                    'max_height' => 60,
                    'platform_capacity' => 227,
                    'outreach' => 37,
                    'weight' => '3,856 Kg',
                ],
                'hourly_rate' => 95.00,
                'daily_rate' => 650.00,
                'monthly_rate' => 11000.00,
                'is_available' => true,
                'image' => $imagePaths[3] ?? null,
            ],
            [
                'name' => 'JLG 1250AJP Ultra Boom',
                'model' => '1250AJP',
                'description' => 'Ultra boom lift with 125-foot working height. Excellent for high-rise construction projects.',
                'specifications' => [
                    'max_height' => 125,
                    'platform_capacity' => 227,
                    'outreach' => 64,
                    'weight' => '8,391 Kg',
                ],
                'hourly_rate' => 195.00,
                'daily_rate' => 1200.00,
                'monthly_rate' => 22000.00,
                'is_available' => true,
                'image' => $imagePaths[4] ?? null,
            ],
            [
                'name' => 'Genie Z-45/25 IC Boom Lift',
                'model' => 'Z-45/25 IC',
                'description' => 'Compact boom lift with 45-foot working height. Perfect for both indoor and outdoor use.',
                'specifications' => [
                    'max_height' => 45,
                    'platform_capacity' => 227,
                    'outreach' => 25,
                    'weight' => '3,538 Kg',
                ],
                'hourly_rate' => 75.00,
                'daily_rate' => 500.00,
                'monthly_rate' => 8500.00,
                'is_available' => true,
                'image' => $imagePaths[5] ?? null,
            ],
            [
                'name' => 'JLG 600S Boom Lift',
                'model' => '600S',
                'description' => 'Compact and versatile boom lift with 60-foot working height. Great for general maintenance.',
                'specifications' => [
                    'max_height' => 60,
                    'platform_capacity' => 227,
                    'outreach' => 35,
                    'weight' => '4,173 Kg',
                ],
                'hourly_rate' => 90.00,
                'daily_rate' => 600.00,
                'monthly_rate' => 10000.00,
                'is_available' => true,
                'image' => $imagePaths[6] ?? null,
            ],
            [
                'name' => 'Skyjack SJ6826 RT Scissor Lift',
                'model' => 'SJ6826 RT',
                'description' => 'Rough terrain scissor lift with 26-foot working height. Ideal for outdoor construction sites.',
                'specifications' => [
                    'max_height' => 26,
                    'platform_capacity' => 454,
                    'outreach' => 0,
                    'weight' => '2,948 Kg',
                ],
                'hourly_rate' => 65.00,
                'daily_rate' => 450.00,
                'monthly_rate' => 7000.00,
                'is_available' => true,
                'image' => $imagePaths[7] ?? null,
            ],
            [
                'name' => 'Genie S-105 Boom Lift',
                'model' => 'S-105',
                'description' => 'High-capacity boom lift with 105-foot working height. Perfect for large construction projects.',
                'specifications' => [
                    'max_height' => 105,
                    'platform_capacity' => 227,
                    'outreach' => 54,
                    'weight' => '6,804 Kg',
                ],
                'hourly_rate' => 165.00,
                'daily_rate' => 1050.00,
                'monthly_rate' => 19000.00,
                'is_available' => true,
                'image' => $imagePaths[8] ?? null,
            ],
            [
                'name' => 'JLG 340AJ Articulating Boom',
                'model' => '340AJ',
                'description' => 'Compact articulating boom lift with 34-foot working height. Excellent for indoor applications.',
                'specifications' => [
                    'max_height' => 34,
                    'platform_capacity' => 227,
                    'outreach' => 24,
                    'weight' => '3,084 Kg',
                ],
                'hourly_rate' => 70.00,
                'daily_rate' => 480.00,
                'monthly_rate' => 8000.00,
                'is_available' => true,
                'image' => $imagePaths[9] ?? null,
            ],
        ];

        foreach ($boomLifts as $boomLift) {
            \App\Models\BoomLift::create($boomLift);
        }

        \App\Models\BoomLift::factory()->count(5)->create();
    }
}
