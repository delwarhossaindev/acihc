<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolHistoryReasonTable extends Migration
{
    public function up()
    {
        Schema::create('ProtocolHistoryReason', function (Blueprint $table) {
            $table->increments('ProtocolHistoryID');
            $table->integer('ProtocolID')->nullable();
            $table->string('Reason', 191)->nullable();
            $table->integer('CreatedBy')->nullable();
            $table->dateTime('CreatedAt')->nullable();

            $table->index('ProtocolID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ProtocolHistoryReason');
    }
}
