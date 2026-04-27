<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolApproverTable extends Migration
{
    public function up()
    {
        Schema::create('ProtocolApprover', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedBigInteger('ProtocolID')->nullable();
            $table->string('UserID', 10)->nullable();
            $table->dateTime('CreateDate')->useCurrent()->nullable();
            $table->string('Comment', 500)->default('');

            $table->index('ProtocolID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ProtocolApprover');
    }
}
