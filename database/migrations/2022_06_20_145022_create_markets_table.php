<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Market', function (Blueprint $table) {
            $table->id('MarketID');
            $table->string('MarketName')->unique();
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
        Schema::dropIfExists('Market');
    }
}
