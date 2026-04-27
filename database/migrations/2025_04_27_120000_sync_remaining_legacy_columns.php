<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ProtocolSkuUnitPack', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolSkuUnitPack', 'Month')) {
                $table->string('Month', 500)->nullable();
            }
            if (! Schema::hasColumn('ProtocolSkuUnitPack', 'Additional')) {
                $table->string('Additional', 500)->nullable();
            }
        });

        Schema::table('ProtocolPlaceboDetail', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolPlaceboDetail', 'Month')) {
                $table->integer('Month')->nullable();
            }
            if (! Schema::hasColumn('ProtocolPlaceboDetail', 'Count')) {
                $table->integer('Count')->nullable();
            }
            if (! Schema::hasColumn('ProtocolPlaceboDetail', 'AditionalSample')) {
                $table->integer('AditionalSample')->nullable();
            }
        });

        Schema::table('PlaceboSkuUnitPack', function (Blueprint $table) {
            if (! Schema::hasColumn('PlaceboSkuUnitPack', 'Month')) {
                $table->string('Month', 500)->nullable();
            }
            if (! Schema::hasColumn('PlaceboSkuUnitPack', 'Additional')) {
                $table->string('Additional', 500)->nullable();
            }
            if (! Schema::hasColumn('PlaceboSkuUnitPack', 'PlaceboTotalSample')) {
                $table->string('PlaceboTotalSample', 500)->nullable();
            }
            if (! Schema::hasColumn('PlaceboSkuUnitPack', 'ProtocolID')) {
                $table->integer('ProtocolID')->nullable();
            }
            if (! Schema::hasColumn('PlaceboSkuUnitPack', 'SkuID')) {
                $table->string('SkuID', 510)->nullable();
            }
        });

        Schema::table('SampleReport', function (Blueprint $table) {
            if (! Schema::hasColumn('SampleReport', 'CreatedAt')) {
                $table->dateTime('CreatedAt')->nullable();
            }
            if (! Schema::hasColumn('SampleReport', 'UpdatedAt')) {
                $table->dateTime('UpdatedAt')->nullable();
            }
        });

        Schema::table('SampleReportDetail', function (Blueprint $table) {
            if (! Schema::hasColumn('SampleReportDetail', 'CreatedAt')) {
                $table->dateTime('CreatedAt')->nullable();
            }
            if (! Schema::hasColumn('SampleReportDetail', 'UpdatedAt')) {
                $table->dateTime('UpdatedAt')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ProtocolSkuUnitPack', function (Blueprint $table) {
            foreach (['Month', 'Additional'] as $c) {
                if (Schema::hasColumn('ProtocolSkuUnitPack', $c)) $table->dropColumn($c);
            }
        });
        Schema::table('ProtocolPlaceboDetail', function (Blueprint $table) {
            foreach (['Month', 'Count', 'AditionalSample'] as $c) {
                if (Schema::hasColumn('ProtocolPlaceboDetail', $c)) $table->dropColumn($c);
            }
        });
        Schema::table('PlaceboSkuUnitPack', function (Blueprint $table) {
            foreach (['Month', 'Additional', 'PlaceboTotalSample', 'ProtocolID', 'SkuID'] as $c) {
                if (Schema::hasColumn('PlaceboSkuUnitPack', $c)) $table->dropColumn($c);
            }
        });
        Schema::table('SampleReport', function (Blueprint $table) {
            foreach (['CreatedAt', 'UpdatedAt'] as $c) {
                if (Schema::hasColumn('SampleReport', $c)) $table->dropColumn($c);
            }
        });
        Schema::table('SampleReportDetail', function (Blueprint $table) {
            foreach (['CreatedAt', 'UpdatedAt'] as $c) {
                if (Schema::hasColumn('SampleReportDetail', $c)) $table->dropColumn($c);
            }
        });
    }
};
