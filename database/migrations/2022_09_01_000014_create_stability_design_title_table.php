<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStabilityDesignTitleTable extends Migration
{
    public function up()
    {
        Schema::create('StabilityDesignTitle', function (Blueprint $table) {
            $table->bigIncrements('StabilityDesignTitleID');
            $table->unsignedBigInteger('ProtocolID')->nullable();
            $table->text('Title')->nullable();
            $table->unsignedBigInteger('CreatedBy')->nullable();
            $table->unsignedBigInteger('UpdatedBy')->nullable();
            $table->string('AdditionalSample', 200)->nullable();
            $table->string('TotalSampleEachCondition', 200)->nullable();

            $table->index('ProtocolID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('StabilityDesignTitle');
    }
}
