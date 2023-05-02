<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'category_name' => 'Mobiles',
        ]);
        Category::create([
            'category_name' => 'Laptop',
        ]);
        Category::create([
            'category_name' => 'Pendrive',
        ]);
        Category::create([
            'category_name' => 'Desktop',
        ]);
        Category::create([
            'category_name' => 'Headphone',
        ]);
        Category::create([
            'category_name' => 'Smartwatch',
        ]);
    }
}
