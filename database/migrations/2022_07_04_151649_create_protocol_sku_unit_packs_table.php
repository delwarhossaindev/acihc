<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolSkuUnitPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolSkuUnitPack', function (Blueprint $table) {
            $table->id('ProtocolSkuUnitPackID');
            $table->integer('ProtocolID');
            $table->integer('SkuID');
            $table->integer('PackID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProtocolSkuUnitPack');
    }
}
