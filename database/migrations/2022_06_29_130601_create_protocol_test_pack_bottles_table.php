<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolTestPackBottlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolTestPackBottle', function (Blueprint $table) {
            $table->id('ProtocolTestPackBottleID');
            $table->integer('ProtocolID');
            $table->integer('PackID');
            $table->integer('SkuID');
            $table->integer('NumberOfBottle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProtocolTestPackBottle');
    }
}
