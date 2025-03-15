<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolBatchSkuSummeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolBatchSkuSummery', function (Blueprint $table) {
            $table->id('ProtocolBatchSkuSummeryID');
            $table->integer('ProtocolBatchSkuID');
            $table->string('BatchNo')->nullable();
            $table->string('BatchSize')->nullable();
            $table->string('MfgDate')->nullable();
            $table->date('StabilityInitiationDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProtocolBatchSkuSummery');
    }
}
