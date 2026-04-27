<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolVersionTable extends Migration
{
    public function up()
    {
        Schema::create('ProtocolVersion', function (Blueprint $table) {
            $table->id();
            $table->integer('protocol_id')->nullable();
            $table->double('version_no')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->nullable();

            $table->index('protocol_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ProtocolVersion');
    }
}
