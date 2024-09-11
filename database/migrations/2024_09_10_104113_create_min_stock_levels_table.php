<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinStockLevelsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('min_stock_levels')) {
            Schema::create('min_stock_levels', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id');
                $table->foreignId('warehouse_id');
                $table->integer('min_stock');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('min_stock_levels');
    }
}
