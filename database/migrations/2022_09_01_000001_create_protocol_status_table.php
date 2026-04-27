<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolStatusTable extends Migration
{
    public function up()
    {
        Schema::create('ProtocolStatus', function (Blueprint $table) {
            $table->integer('ProtocolStatusID')->nullable();
            $table->string('ProtocolStatus', 50)->nullable();
            $table->char('Active', 1)->default('Y')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ProtocolStatus');
    }
}
