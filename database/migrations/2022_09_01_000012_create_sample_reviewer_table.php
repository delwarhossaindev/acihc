<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleReviewerTable extends Migration
{
    public function up()
    {
        Schema::create('SampleReviewer', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedBigInteger('SampleReportID')->nullable();
            $table->string('UserID', 10)->nullable();
            $table->dateTime('CreateDate')->useCurrent()->nullable();
            $table->string('Comment', 500)->default('');

            $table->index('SampleReportID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('SampleReviewer');
    }
}
