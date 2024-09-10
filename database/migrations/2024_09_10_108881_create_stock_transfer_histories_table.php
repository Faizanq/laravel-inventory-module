<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransferHistoriesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('stock_transfer_history')) {
            Schema::create('stock_transfer_history', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained('products');
                $table->foreignId('warehouse_id')->nullable()->constrained('warehouses');
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
                $table->integer('quantity_change');
                $table->enum('type', ['STOCK_IN', 'STOCK_OUT']);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('stock_transfer_history');
    }
}
