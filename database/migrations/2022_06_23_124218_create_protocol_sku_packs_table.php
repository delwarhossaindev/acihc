<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolSkuPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolSkuPack', function (Blueprint $table) {
            $table->id('ProtocolSkuPackID');
            $table->integer('ProtocolID')->nullable();
            $table->integer('SkuID')->nullable();
            $table->integer('ContainerID')->nullable();
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
        Schema::dropIfExists('ProtocolSkuPack');
    }
}
