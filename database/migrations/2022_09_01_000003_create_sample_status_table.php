<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleStatusTable extends Migration
{
    public function up()
    {
        Schema::create('SampleStatus', function (Blueprint $table) {
            $table->integer('SampleStatusID')->nullable();
            $table->string('SampleStatus', 50)->nullable();
            $table->char('Active', 1)->default('Y')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('SampleStatus');
    }
}
