<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseStocksTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('warehouse_stocks')) {
            Schema::create('warehouse_stocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id');
                $table->foreignId('warehouse_id');
                $table->integer('min_stock')->default(0);
                $table->integer('available_stock');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('warehouse_stocks');
    }
}
