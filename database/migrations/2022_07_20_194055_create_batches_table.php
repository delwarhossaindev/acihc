<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Batch', function (Blueprint $table) {
            $table->id('BatchID');
            $table->string('BatchName')->nullable();
            $table->string('BatchNo')->nullable();
            $table->string('BatchSize')->nullable();
            $table->date('MfgDate')->nullable();
            $table->date('ExpDate')->nullable();
            $table->date('SIDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Batch');
    }
}
