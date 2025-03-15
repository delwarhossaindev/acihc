<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ApiDetail', function (Blueprint $table) {
            $table->id('ApiDetailID');
            $table->string('ApiDetailName');
            $table->string('APIDetailSource');
            $table->date('ExpDate')->nullable();
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
        Schema::dropIfExists('ApiDetail');
    }
}
