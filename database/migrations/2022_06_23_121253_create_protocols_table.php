<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Protocol', function (Blueprint $table) {
            $table->id('ProtocolID');
            $table->integer('ProductID')->nullable();
            $table->integer('MarketID')->nullable();
            $table->integer('ManufacturerID')->nullable();
            $table->string('Title')->nullable();;
            $table->mediumText('Purpose')->nullable();
            $table->mediumText('Scope')->nullable();
            $table->mediumText('Responsibilities')->nullable();
            $table->string('Reference')->nullable();
            $table->mediumText('AnalysisReport')->nullable();
            $table->mediumText('Reporting')->nullable();
            $table->mediumText('Conclusion')->nullable();
            $table->mediumText('RevisionHistory')->nullable();
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
        Schema::dropIfExists('Protocol');
    }
}
