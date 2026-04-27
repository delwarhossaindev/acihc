<?php

use App\Models\StudyType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudyTypeDetail', function (Blueprint $table) {
            $table->id('StudyTypeDetailID');
            $table->integer('StudyTypeID');
            $table->string('StudyTypeMonth');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StudyTypeDetail');
    }
}
