<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolApprovalTreeTable extends Migration
{
    public function up()
    {
        Schema::create('ProtocolApprovalTree', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->unsignedBigInteger('ProtocolID')->nullable();
            $table->string('UserID', 10)->nullable();
            $table->integer('ProtocolApprovalTypeID')->nullable();
            $table->dateTime('CreateDate')->useCurrent()->nullable();

            $table->index('ProtocolID');
            $table->index('ProtocolApprovalTypeID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ProtocolApprovalTree');
    }
}
