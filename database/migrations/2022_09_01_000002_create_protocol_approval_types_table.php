<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolApprovalTypesTable extends Migration
{
    public function up()
    {
        Schema::create('ProtocolApprovalType', function (Blueprint $table) {
            $table->integer('ProtocolApprovalTypeID');
            $table->string('ProtocolApprovalType', 100)->default('')->nullable();
            $table->char('Active', 1)->default('Y');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ProtocolApprovalType');
    }
}
