<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAPIDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProductAPIDetail', function (Blueprint $table) {
            $table->id('ProductAPIDetailID');
            $table->integer('ProductID')->nullable();
            $table->integer('ApiDetailID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_a_p_i_details');
    }
}
