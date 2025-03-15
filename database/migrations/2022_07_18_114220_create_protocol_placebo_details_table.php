<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolPlaceboDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolPlaceboDetail', function (Blueprint $table) {
            $table->id('ProtocolPlaceboDetailID');
            $table->integer('PlaceboID');
            $table->integer('StudyTypeID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProtocolPlaceboDetail');
    }
}
