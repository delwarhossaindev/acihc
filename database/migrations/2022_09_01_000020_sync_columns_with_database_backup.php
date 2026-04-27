<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyncColumnsWithDatabaseBackup extends Migration
{
    public function up()
    {
        Schema::table('Protocol', function (Blueprint $table) {
            if (! Schema::hasColumn('Protocol', 'ProtocolStatusID')) {
                $table->integer('ProtocolStatusID')->nullable()->after('ProductID');
            }
            if (! Schema::hasColumn('Protocol', 'CreatedDate')) {
                $table->dateTime('CreatedDate')->useCurrent()->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'Note')) {
                $table->text('Note')->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'FooterSectionNo')) {
                $table->string('FooterSectionNo', 191)->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'PreviousProtocolID')) {
                $table->integer('PreviousProtocolID')->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'Reason')) {
                $table->string('Reason', 200)->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'ExhibitBatch')) {
                $table->string('ExhibitBatch', 10)->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'CommercialValidationBatch')) {
                $table->string('CommercialValidationBatch', 10)->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'AnnualStability')) {
                $table->string('AnnualStability', 10)->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'Other')) {
                $table->string('Other', 200)->nullable();
            }
            if (! Schema::hasColumn('Protocol', 'TestNote')) {
                $table->text('TestNote')->nullable();
            }
        });

        Schema::table('Sample', function (Blueprint $table) {
            if (! Schema::hasColumn('Sample', 'SampleStatusID')) {
                $table->integer('SampleStatusID')->nullable()->after('ProductID');
            }
            if (! Schema::hasColumn('Sample', 'PackagingDate')) {
                $table->date('PackagingDate')->nullable();
            }
            if (! Schema::hasColumn('Sample', 'Headline')) {
                $table->text('Headline')->nullable();
            }
            if (! Schema::hasColumn('Sample', 'Note')) {
                $table->text('Note')->nullable();
            }
            if (! Schema::hasColumn('Sample', 'FooterSection')) {
                $table->string('FooterSection', 191)->nullable();
            }
            if (! Schema::hasColumn('Sample', 'STPNo')) {
                $table->string('STPNo', 191)->nullable();
            }
            if (! Schema::hasColumn('Sample', 'SpecificationNo')) {
                $table->string('SpecificationNo', 191)->nullable();
            }
        });

        Schema::table('SampleReport', function (Blueprint $table) {
            if (! Schema::hasColumn('SampleReport', 'StudyTypeID')) {
                $table->integer('StudyTypeID')->nullable();
            }
            if (! Schema::hasColumn('SampleReport', 'SkuID')) {
                $table->integer('SkuID')->nullable();
            }
            if (! Schema::hasColumn('SampleReport', 'PackID')) {
                $table->char('PackID', 10)->nullable();
            }
            if (! Schema::hasColumn('SampleReport', 'UserID')) {
                $table->integer('UserID')->nullable();
            }
            if (! Schema::hasColumn('SampleReport', 'SampleReportStatusID')) {
                $table->integer('SampleReportStatusID')->nullable();
            }
            if (! Schema::hasColumn('SampleReport', 'Headline')) {
                $table->string('Headline', 191)->nullable();
            }
            if (! Schema::hasColumn('SampleReport', 'Note')) {
                $table->string('Note', 2000)->nullable();
            }
        });

        Schema::table('SampleReportDetail', function (Blueprint $table) {
            if (! Schema::hasColumn('SampleReportDetail', 'SubTestID')) {
                $table->integer('SubTestID')->nullable();
            }
            if (! Schema::hasColumn('SampleReportDetail', 'Value')) {
                $table->string('Value', 300)->nullable();
            }
            if (! Schema::hasColumn('SampleReportDetail', 'Specification')) {
                $table->string('Specification', 291)->nullable();
            }
        });

        Schema::table('Batch', function (Blueprint $table) {
            if (! Schema::hasColumn('Batch', 'ProductID')) {
                $table->integer('ProductID')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'SkuID')) {
                $table->integer('SkuID')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'PackID')) {
                $table->string('PackID', 50)->nullable();
            }
            if (! Schema::hasColumn('Batch', 'Month')) {
                $table->integer('Month')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'ProtocolID')) {
                $table->integer('ProtocolID')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'ProductName')) {
                $table->string('ProductName', 191)->nullable();
            }
            if (! Schema::hasColumn('Batch', 'DescriptionOfPack')) {
                $table->string('DescriptionOfPack', 400)->nullable();
            }
            if (! Schema::hasColumn('Batch', 'WithdrawalDate')) {
                $table->date('WithdrawalDate')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'IsWithdrawal')) {
                $table->integer('IsWithdrawal')->default(0)->nullable();
            }
            if (! Schema::hasColumn('Batch', 'IsWithdrawalDate')) {
                $table->date('IsWithdrawalDate')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'WithdrawalBy')) {
                $table->integer('WithdrawalBy')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'CreatedBy')) {
                $table->integer('CreatedBy')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'UpdatedBy')) {
                $table->integer('UpdatedBy')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'CreatedAt')) {
                $table->dateTime('CreatedAt')->nullable();
            }
            if (! Schema::hasColumn('Batch', 'UpdatedAt')) {
                $table->dateTime('UpdatedAt')->nullable();
            }
        });

        Schema::table('Test', function (Blueprint $table) {
            if (! Schema::hasColumn('Test', 'TestType')) {
                $table->string('TestType', 191)->nullable();
            }
        });

        Schema::table('Subtest', function (Blueprint $table) {
            if (! Schema::hasColumn('Subtest', 'TestType')) {
                $table->string('TestType', 191)->nullable();
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'designation')) {
                $table->string('designation', 191)->nullable();
            }
            if (! Schema::hasColumn('users', 'staff_id')) {
                $table->string('staff_id', 191)->nullable();
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->integer('status')->default(1)->nullable();
            }
        });

        Schema::table('settings', function (Blueprint $table) {
            if (! Schema::hasColumn('settings', 'display_name')) {
                $table->string('display_name', 191)->after('id');
            }
        });

        Schema::table('ProtocolBatch', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolBatch', 'SkuID')) {
                $table->integer('SkuID')->nullable();
            }
            if (! Schema::hasColumn('ProtocolBatch', 'BatchNo')) {
                $table->string('BatchNo', 200)->nullable();
            }
            if (! Schema::hasColumn('ProtocolBatch', 'BatchSize')) {
                $table->string('BatchSize', 200)->nullable();
            }
            if (! Schema::hasColumn('ProtocolBatch', 'MfgDate')) {
                $table->string('MfgDate', 200)->nullable();
            }
            if (! Schema::hasColumn('ProtocolBatch', 'StabilityInitiationDate')) {
                $table->string('StabilityInitiationDate', 200)->nullable();
            }
        });

        Schema::table('ProtocolAPIDetail', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolAPIDetail', 'ExpDate')) {
                $table->date('ExpDate')->nullable();
            }
            if (! Schema::hasColumn('ProtocolAPIDetail', 'BatchNo')) {
                $table->string('BatchNo', 200)->default('')->nullable();
            }
        });

        Schema::table('ProtocolProductDetail', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolProductDetail', 'SpecificationNo')) {
                $table->string('SpecificationNo', 191)->nullable();
            }
            if (! Schema::hasColumn('ProtocolProductDetail', 'STPNo')) {
                $table->string('STPNo', 191)->nullable();
            }
        });

        Schema::table('ProtocolSkuPack', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolSkuPack', 'ContainerID')) {
                $table->integer('ContainerID')->nullable();
            }
        });

        Schema::table('ProtocolStabilityStudy', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolStabilityStudy', 'ConditionID')) {
                $table->integer('ConditionID')->nullable();
            }
        });

        Schema::table('ProtocolStabilityChamberDesign', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolStabilityChamberDesign', 'AditionalSample')) {
                $table->integer('AditionalSample')->nullable();
            }
        });

        Schema::table('ProtocolSkuUnitPack', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolSkuUnitPack', 'TotalSample')) {
                $table->string('TotalSample', 500)->nullable();
            }
        });

        Schema::table('ProtocolSkuPackContainer', function (Blueprint $table) {
            if (! Schema::hasColumn('ProtocolSkuPackContainer', 'SkuID')) {
                $table->integer('SkuID')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('Protocol', function (Blueprint $table) {
            $columns = ['ProtocolStatusID', 'CreatedDate', 'Note', 'FooterSectionNo', 'PreviousProtocolID', 'Reason', 'ExhibitBatch', 'CommercialValidationBatch', 'AnnualStability', 'Other', 'TestNote'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('Protocol', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('Sample', function (Blueprint $table) {
            $columns = ['SampleStatusID', 'PackagingDate', 'Headline', 'Note', 'FooterSection', 'STPNo', 'SpecificationNo'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('Sample', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('SampleReport', function (Blueprint $table) {
            $columns = ['StudyTypeID', 'SkuID', 'PackID', 'UserID', 'SampleReportStatusID', 'Headline', 'Note'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('SampleReport', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('SampleReportDetail', function (Blueprint $table) {
            foreach (['SubTestID', 'Value', 'Specification'] as $col) {
                if (Schema::hasColumn('SampleReportDetail', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('Batch', function (Blueprint $table) {
            $columns = ['ProductID', 'SkuID', 'PackID', 'Month', 'ProtocolID', 'ProductName', 'DescriptionOfPack', 'WithdrawalDate', 'IsWithdrawal', 'IsWithdrawalDate', 'WithdrawalBy', 'CreatedBy', 'UpdatedBy', 'CreatedAt', 'UpdatedAt'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('Batch', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('Test', function (Blueprint $table) {
            if (Schema::hasColumn('Test', 'TestType')) {
                $table->dropColumn('TestType');
            }
        });

        Schema::table('Subtest', function (Blueprint $table) {
            if (Schema::hasColumn('Subtest', 'TestType')) {
                $table->dropColumn('TestType');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            foreach (['designation', 'staff_id', 'status'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'display_name')) {
                $table->dropColumn('display_name');
            }
        });

        Schema::table('ProtocolBatch', function (Blueprint $table) {
            foreach (['SkuID', 'BatchNo', 'BatchSize', 'MfgDate', 'StabilityInitiationDate'] as $col) {
                if (Schema::hasColumn('ProtocolBatch', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('ProtocolAPIDetail', function (Blueprint $table) {
            foreach (['ExpDate', 'BatchNo'] as $col) {
                if (Schema::hasColumn('ProtocolAPIDetail', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('ProtocolProductDetail', function (Blueprint $table) {
            foreach (['SpecificationNo', 'STPNo'] as $col) {
                if (Schema::hasColumn('ProtocolProductDetail', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('ProtocolSkuPack', function (Blueprint $table) {
            if (Schema::hasColumn('ProtocolSkuPack', 'ContainerID')) {
                $table->dropColumn('ContainerID');
            }
        });

        Schema::table('ProtocolStabilityStudy', function (Blueprint $table) {
            if (Schema::hasColumn('ProtocolStabilityStudy', 'ConditionID')) {
                $table->dropColumn('ConditionID');
            }
        });

        Schema::table('ProtocolStabilityChamberDesign', function (Blueprint $table) {
            if (Schema::hasColumn('ProtocolStabilityChamberDesign', 'AditionalSample')) {
                $table->dropColumn('AditionalSample');
            }
        });

        Schema::table('ProtocolSkuUnitPack', function (Blueprint $table) {
            if (Schema::hasColumn('ProtocolSkuUnitPack', 'TotalSample')) {
                $table->dropColumn('TotalSample');
            }
        });

        Schema::table('ProtocolSkuPackContainer', function (Blueprint $table) {
            if (Schema::hasColumn('ProtocolSkuPackContainer', 'SkuID')) {
                $table->dropColumn('SkuID');
            }
        });
    }
}
