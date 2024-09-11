<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        // Sample suppliers data
        $suppliers = [
            ['name' => 'Supplier One', 'email' => 'supplier1@example.com'],
            ['name' => 'Supplier Two', 'email' => 'supplier2@example.com'],
        ];

        DB::table('min_stock_levels')->truncate();
        DB::table('suppliers')->insert($suppliers);
    }
}
