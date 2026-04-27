<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolTestPackBottlesTable extends Migration
{
    public function up()
    {
        Schema::create('ProtocolTestPackBottle', function (Blueprint $table) {
            $table->id('ProtocolTestPackBottleID');
            $table->integer('ProtocolID');
            $table->string('PackID', 400);
            $table->string('NumberOfBottle', 400);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ProtocolTestPackBottle');
    }
}
