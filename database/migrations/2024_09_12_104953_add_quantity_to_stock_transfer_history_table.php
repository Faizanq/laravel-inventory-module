<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('stock_transfer_history', 'quantity')) {
            Schema::table('stock_transfer_history', function (Blueprint $table) {
                $table->integer('quantity')->nullable()->after('quantity_change');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('stock_transfer_history', 'quantity')) {
            Schema::table('stock_transfer_history', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }
};
