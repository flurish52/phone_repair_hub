<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === Top-level categories ===
        $phones = Category::updateOrCreate(
            ['slug' => Str::slug('Phones & Tablets')],
            ['name' => 'Phones & Tablets', 'parent_id' => null]
        );

        $accessories = Category::updateOrCreate(
            ['slug' => Str::slug('Accessories')],
            ['name' => 'Accessories', 'parent_id' => null]
        );

        $parts = Category::updateOrCreate(
            ['slug' => Str::slug('Parts & Replacements')],
            ['name' => 'Parts & Replacements', 'parent_id' => null]
        );

        $tools = Category::updateOrCreate(
            ['slug' => Str::slug('Repair Tools & Materials')],
            ['name' => 'Repair Tools & Materials', 'parent_id' => null]
        );

        $electronics = Category::updateOrCreate(
            ['slug' => Str::slug('Electronics (General)')],
            ['name' => 'Electronics (General)', 'parent_id' => null]
        );

        // === Subcategories for Accessories ===
        $accessorySubs = [
            'Chargers', 'Cables', 'Earphones', 'Power Banks', 'Screen Protectors'
        ];
        foreach ($accessorySubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $accessories->id]
            );
        }

        // === Subcategories for Parts & Replacements ===
        $partSubs = ['Batteries', 'Screens', 'Motherboards', 'Charging Ports', 'Camera Modules'];
        foreach ($partSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $parts->id]
            );
        }

        // === Subcategories for Tools ===
        $toolSubs = ['Screwdrivers', 'Heat Guns', 'Soldering Tools', 'Cleaning Kits'];
        foreach ($toolSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub)],
                ['name' => $sub, 'parent_id' => $tools->id]
            );
        }
    }
}
