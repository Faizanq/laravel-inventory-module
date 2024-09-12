<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStockTransferHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('stock_transfer_history', 'transfer_date')) {
            Schema::table('stock_transfer_history', function (Blueprint $table) {
                $table->timestamp('transfer_date')->nullable()->after('type');
            });
        }

        if (!Schema::hasColumn('stock_transfer_history', 'stock_transfer_id')) {
            Schema::table('stock_transfer_history', function (Blueprint $table) {
                $table->unsignedBigInteger('stock_transfer_id')->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('stock_transfer_history', 'transfer_date')) {
            Schema::table('stock_transfer_history', function (Blueprint $table) {
                $table->dropColumn('transfer_date');
            });
        }

        if (Schema::hasColumn('stock_transfer_history', 'stock_transfer_id')) {
            Schema::table('stock_transfer_history', function (Blueprint $table) {
                $table->dropColumn('stock_transfer_id');
            });
        }
    }
}
