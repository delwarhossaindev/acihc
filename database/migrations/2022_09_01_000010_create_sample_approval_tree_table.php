<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleApprovalTreeTable extends Migration
{
    public function up()
    {
        Schema::create('SampleApprovalTree', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->unsignedBigInteger('SampleReportID')->nullable();
            $table->string('UserID', 10)->nullable();
            $table->integer('SampleApprovalTypeID')->nullable();
            $table->dateTime('CreateDate')->useCurrent()->nullable();

            $table->index('SampleReportID');
            $table->index('SampleApprovalTypeID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('SampleApprovalTree');
    }
}
