<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolSkuTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolSkuTest', function (Blueprint $table) {
            $table->id('ProtocolSkuTestID');
            $table->integer('ProtocolTestID')->nullable();
            $table->integer('SkuID')->nullable();
            $table->integer('UnitPerTest')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProtocolSkuTest');
    }
}
