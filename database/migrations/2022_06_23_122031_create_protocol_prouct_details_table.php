<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolProuctDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolProductDetail', function (Blueprint $table) {
            $table->id('ProtocolProductDetailID');
            $table->integer('ProtocolID')->nullable();
            $table->integer('ProductID')->nullable();
            $table->integer('SkuID')->nullable();
            $table->string('SpecificationNo')->nullable();
            $table->string('STPNo')->nullable();
            $table->foreignIdFor(User::class, 'CreatedBy')->nullable();
            $table->foreignIdFor(User::class, 'UpdatedBy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protocol_prouct_details');
    }
}
