<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceboSkuUnitPackTable extends Migration
{
    public function up()
    {
        Schema::create('PlaceboSkuUnitPack', function (Blueprint $table) {
            $table->bigIncrements('PlaceboSkuUnitPackID');
            $table->integer('ProtocolID');
            $table->string('SkuID', 510)->nullable();
            $table->string('Month', 500)->nullable();
            $table->string('Additional', 500)->nullable();
            $table->string('PlaceboTotalSample', 500)->nullable();

            $table->index('ProtocolID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('PlaceboSkuUnitPack');
    }
}
