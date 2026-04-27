<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleApprovalTypesTable extends Migration
{
    public function up()
    {
        Schema::create('SampleApprovalType', function (Blueprint $table) {
            $table->integer('SampleApprovalTypeID');
            $table->string('SampleApprovalType', 100)->default('')->nullable();
            $table->char('Active', 1)->default('Y');
        });
    }

    public function down()
    {
        Schema::dropIfExists('SampleApprovalType');
    }
}
