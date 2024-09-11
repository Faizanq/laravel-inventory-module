<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransfersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('stock_transfers')) {
            Schema::create('stock_transfers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id');
                $table->foreignId('from_supplier_id')->nullable();
                $table->foreignId('from_warehouse_id')->nullable();
                $table->foreignId('to_warehouse_id');
                $table->integer('quantity');
                $table->timestamp('transfer_date')->useCurrent();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('stock_transfers');
    }
}
