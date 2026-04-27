<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleReportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SampleReportDetail', function (Blueprint $table) {
            $table->id('SampleReportDetailID');
            $table->integer('SampleReportID');
            $table->integer('TestID')->nullable();
            $table->integer('SubTestID')->nullable();
            $table->string('Value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SampleReportDetail');
    }
}
