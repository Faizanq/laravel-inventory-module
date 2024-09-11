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
            ['name' => 'Product One', 'sku' => 'P001', 'quantity_in_stock' => 100,],
            ['name' => 'Product Two', 'sku' => 'P002', 'quantity_in_stock' => 50],
            ['name' => 'Product Three', 'sku' => 'P003', 'quantity_in_stock' => 150,],
        ];
        DB::table('products')->truncate();
        DB::table('products')->insert($products);
    }
}
