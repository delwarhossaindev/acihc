<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sample', function (Blueprint $table) {
            $table->id('SampleID');
            $table->integer('ManufacturerID');
            $table->integer('ProductID');
            $table->integer('ProtocolID');
            $table->string('GRN_NUMBER')->nullable();
            $table->mediumText('Remark')->nullable();
            $table->date('ReceivingDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Sample');
    }
}
