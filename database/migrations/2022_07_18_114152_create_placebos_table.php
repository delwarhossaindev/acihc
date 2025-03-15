<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacebosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Placebo', function (Blueprint $table) {
            $table->id('PlaceboID');
            $table->integer('ProtocolID');
            $table->integer('SkuID');
            $table->integer('PackID');
            $table->integer('Month');
            $table->integer('Aditional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Placebo');
    }
}
