<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinStockLevelsSeeder extends Seeder
{
    public function run()
    {
        // Sample data for min_stock_levels
        $minStockLevels = [
            ['product_id' => 1, 'warehouse_id' => 1, 'min_stock' => 10],
            ['product_id' => 1, 'warehouse_id' => 2, 'min_stock' => 20],
            ['product_id' => 2, 'warehouse_id' => 3, 'min_stock' => 15],
            ['product_id' => 3, 'warehouse_id' => 1, 'min_stock' => 25],
            ['product_id' => 3, 'warehouse_id' => 2, 'min_stock' => 30],
        ];

        DB::table('min_stock_levels')->truncate();
        DB::table('min_stock_levels')->insert($minStockLevels);
    }
}
