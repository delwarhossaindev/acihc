<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolStabilityStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolStabilityStudy', function (Blueprint $table) {
            $table->id('ProtocolStabilityStudyID');
            $table->integer('ProtocolID')->nullable();
            $table->integer('StudyTypeID')->nullable();
            $table->integer('ConditionID')->nullable();
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
        Schema::dropIfExists('ProtocolStabilityStudy');
    }
}
