<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('warehouses')) {
            Schema::create('warehouses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                // $table->string('code');
                $table->string('location');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
