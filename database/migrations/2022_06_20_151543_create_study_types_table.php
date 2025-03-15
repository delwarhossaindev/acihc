<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudyType', function (Blueprint $table) {
            $table->id('StudyTypeID');
            $table->string('StudyTypeName');
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
        Schema::dropIfExists('StudyType');
    }
}
