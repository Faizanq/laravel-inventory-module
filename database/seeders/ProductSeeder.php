<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Sample products data
        $products = [
            ['name' => 'Product One', 'sku' => 'P001'],
            ['name' => 'Product Two', 'sku' => 'P002'],
            ['name' => 'Product Three', 'sku' => 'P003'],
        ];
        DB::table('products')->truncate();
        DB::table('products')->insert($products);
    }
}
