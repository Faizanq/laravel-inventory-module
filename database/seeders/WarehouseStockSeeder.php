<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseStockSeeder extends Seeder
{
    public function run()
    {
        // Sample data for warehouse_stocks
        $warehouseStock = [
            ['product_id' => 1, 'warehouse_id' => 1, 'min_stock' => 10, 'available_stock' => 50],
            ['product_id' => 1, 'warehouse_id' => 2, 'min_stock' => 20, 'available_stock' => 10],
            ['product_id' => 2, 'warehouse_id' => 3, 'min_stock' => 15, 'available_stock' => 40],
            ['product_id' => 3, 'warehouse_id' => 1, 'min_stock' => 25, 'available_stock' => 45],
            ['product_id' => 3, 'warehouse_id' => 2, 'min_stock' => 30, 'available_stock' => 55],
        ];

        DB::table('warehouse_stocks')->truncate();
        DB::table('warehouse_stocks')->insert($warehouseStock);
    }
}
