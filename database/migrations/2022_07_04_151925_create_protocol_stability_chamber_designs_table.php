<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolStabilityChamberDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolStabilityChamberDesign', function (Blueprint $table) {
            $table->id('ProtocolStabilityChamberDesignID');
            $table->integer('ProtocolSkuUnitPackID');
            $table->integer('Month');
            $table->integer('StudyTypeID');
            $table->integer('Count');
            $table->integer('AditionalSample')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProtocolStabilityChamberDesign');
    }
}
