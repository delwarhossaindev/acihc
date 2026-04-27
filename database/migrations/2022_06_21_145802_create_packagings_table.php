<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Packaging', function (Blueprint $table) {
            $table->id('PackagingID');
            $table->string('PackagingName');
            $table->string('PackagingSource');
            $table->string('PackagingDMF')->nullable();
            $table->string('PackagingResin')->nullable();
            $table->string('PackagingColorant')->nullable();
            $table->string('PackagingLiner')->nullable();
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
        Schema::dropIfExists('Packaging');
    }
}
