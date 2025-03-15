<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\SampleController;
use App\Http\Controllers\System\SampleReportController;

Route::middleware(['auth'])->group(function () {
    Route::get('sample',[SampleController::class,'index'])->name('sample.index');
    Route::post('sample/store',[SampleController::class,'store'])->name('sample.store');
    Route::get('sample/{sample}/edit',[SampleController::class,'edit'])->name('sample.edit');
    Route::get('sample/{sample}/create',[SampleController::class,'show'])->name('sample.show');
    Route::patch('sample/{sample}/update',[SampleController::class,'store'])->name('sample.update');
    Route::post('sample/{sample}/delete',[SampleController::class,'delete'])->name('sample.delete');
    Route::get('all/sample_report',[SampleReportController::class,'index'])->name('sample.report.index');
    Route::post('sample/{sample}/store',[SampleReportController::class,'sampleStore'])->name('sample.submit');
    Route::get('sample_report/{sample_report}/report',[SampleReportController::class,'report'])->name('sample.report');
    Route::get('sample_report/{sample_report}/edit',[SampleReportController::class,'edit'])->name('samplereport.edit');
    Route::put('/sampleReport/update/{id}', [SampleReportController::class, 'update'])->name('sampleReport.update');
    Route::post('sample_report/{sample_report}/report/delete',[SampleReportController::class,'delete'])->name('sample.report.delete');

    //approval sample report
    Route::post('approval/sample/store',[SampleReportController::class,'approvalSampleStore'])->name('approval.sample.store');
    Route::get('/sample/approval-details/{id}', [SampleReportController::class, 'getApprovalDetails'])->name('sample.approval.details');
    Route::get('/sample/{id}/approval-data', [SampleReportController::class, 'getApprovalData'])->name('sample.approval.data');
    Route::post('sample/approval/{sample_report}/store',[SampleReportController::class,'sampleApprovalDesign'])->name('sample.approval.store');
});