<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        // Sample warehouses data
        $warehouses = [
            ['name' => 'Warehouse A', 'location' => 'Location A'],
            ['name' => 'Warehouse B', 'location' => 'Location B'],
            ['name' => 'Warehouse C', 'location' => 'Location C'],
        ];

        DB::table('warehouses')->truncate();
        DB::table('warehouses')->truncate();
    }
}
