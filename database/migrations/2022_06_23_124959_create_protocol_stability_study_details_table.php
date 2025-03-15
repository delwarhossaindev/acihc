<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolStabilityStudyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ProtocolStabilityStudyDetail', function (Blueprint $table) {
            $table->id('ProtocolStabilityStudyDetailID');
            $table->integer('ProtocolStabilityStudyID')->nullable();
            $table->string('TestingMonth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProtocolStabilityStudyDetail');
    }
}
