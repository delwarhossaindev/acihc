<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\ProtocolController;

Route::middleware(['auth'])->group(function () {
    Route::get('protocols',[ProtocolController::class,'index'])->name('protocol');
    Route::get('protocol/create',[ProtocolController::class,'create'])->name('protocol.create');
    Route::get('protocol/{protocol}/edit',[ProtocolController::class,'edit'])->name('protocol.edit');
    Route::get('protocol/{protocol}/details',[ProtocolController::class,'show'])->name('protocol.show');
    Route::post('protocols',[ProtocolController::class,'store'])->name('protocol.store');
    Route::post('protocols/update/{protocol}',[ProtocolController::class,'updateProtocol'])->name('protocol.update');
    Route::post('protocols/product/{protocol}/store',[ProtocolController::class,'storeProductDetails'])->name('protocol.product.store');
    Route::post('protocols/container/{protocol}/store',[ProtocolController::class,'storeSkuContainerStore'])->name('protocol.container.store');
    Route::post('protocols/packaging/{protocol}/store',[ProtocolController::class,'storeProtocolPackagingProfile'])->name('protocol.packaging.store');
    Route::post('protocols/stability/{protocol}/store',[ProtocolController::class,'storeProtocolStabilityStudy'])->name('protocol.stability.store');
    Route::post('protocols/test/{protocol}/store',[ProtocolController::class,'storeProtocolTestDetail'])->name('protocol.test.store');
    Route::post('protocols/api/{protocol}/store',[ProtocolController::class,'storeProtocolAPIDetail'])->name('protocol.api.store');
    Route::post('protocols/chamber/{protocol}/store',[ProtocolController::class,'protocolChamberDesign'])->name('protocol.chamber.store');
    Route::post('protocols/placebo/{protocol}/store',[ProtocolController::class,'protocolPlaceboDesign'])->name('protocol.placebo.store');
    Route::post('protocols/batch/{protocol}/store',[ProtocolController::class,'protocolBatchDesign'])->name('protocol.batch.store');
    Route::post('approval/protocal/store',[ProtocolController::class,'approvalProtocalStore'])->name('approval.protocal.store');
    Route::get('/protocol/{id}/approval-details', [ProtocolController::class, 'getApprovalDetails'])->name('protocol.approval.details');
    Route::post('protocols/approval/{protocol}/store',[ProtocolController::class,'protocolApprovalDesign'])->name('protocol.approval.store');
    Route::post('protocols/reason/store',[ProtocolController::class,'reasonStore'])->name('reason.store');

});