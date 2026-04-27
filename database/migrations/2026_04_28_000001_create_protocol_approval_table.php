<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ProtocolApproval', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->unsignedBigInteger('ProtocolID');
            $table->unsignedInteger('StepOrder');
            $table->enum('Role', ['Reviewer', 'Approver']);
            $table->unsignedBigInteger('AssignedUserID');
            $table->unsignedBigInteger('AssignedBy')->nullable();
            $table->dateTime('AssignedAt')->useCurrent();
            $table->enum('Decision', ['Pending', 'Approved', 'Declined'])->default('Pending');
            $table->text('Comment')->nullable();
            $table->dateTime('DecidedAt')->nullable();

            $table->unique(['ProtocolID', 'StepOrder']);
            $table->index(['AssignedUserID', 'Decision']);
            $table->index('ProtocolID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ProtocolApproval');
    }
};
