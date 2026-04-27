<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('BatchDetails', function (Blueprint $table) {
            $table->increments('BatchDetailsID');
            $table->integer('BatchID')->nullable();
            $table->char('ConditionID', 10)->nullable();
            $table->date('WithdrawalDate')->nullable();
            $table->integer('Month')->nullable();
            $table->date('IsWithdrawalDate')->nullable();
            $table->integer('IsWithdrawal')->nullable();
            $table->integer('WithdrawalBy')->nullable();

            $table->index('BatchID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('BatchDetails');
    }
}
