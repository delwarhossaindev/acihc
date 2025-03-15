<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolPackagingPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolPackagingPack', function (Blueprint $table) {
            $table->id('ProtocolPackagingPackID');
            $table->integer('ProtocolID');
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
        Schema::dropIfExists('ProtocolPackagingPack');
    }
}
