<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\ApiController;
use App\Http\Controllers\System\AjaxController;
use App\Http\Controllers\System\PackController;
use App\Http\Controllers\System\TestController;
use App\Http\Controllers\System\BatchController;
use App\Http\Controllers\System\StudyController;
use App\Http\Controllers\System\MarketController;
use App\Http\Controllers\System\ProductController;
use App\Http\Controllers\System\SubtestController;
use App\Http\Controllers\System\ConditionController;
use App\Http\Controllers\System\ContainerController;
use App\Http\Controllers\System\PackagingController;
use App\Http\Controllers\System\ManufacturerController;

Route::middleware(['auth'])->group(function () {

  Route::get('manufacturer',[ManufacturerController::class,'index'])->name('manufacturer');
  Route::post('manufacturer',[ManufacturerController::class,'store'])->name('manufacturer.store');
  Route::get('manufacturer/{manufacturer}/edit',[ManufacturerController::class,'edit'])->name('manufacturer.edit');
  Route::patch('manufacturer/{manufacturer}',[ManufacturerController::class,'update'])->name('manufacturer.update');
  Route::post('manufacturer/{manufacturer}/delete',[ManufacturerController::class,'delete'])->name('manufacturer.delete');

  Route::get('market',[MarketController::class,'index'])->name('market');
  Route::post('market',[MarketController::class,'store'])->name('market.store');
  Route::get('market/{market}/edit',[MarketController::class,'edit'])->name('market.edit');
  Route::patch('market/{market}',[MarketController::class,'update'])->name('market.update');
  Route::post('market/{market}/delete',[MarketController::class,'delete'])->name('market.delete');

  Route::get('studytype',[StudyController::class,'index'])->name('studytype');
  Route::post('studytype',[StudyController::class,'store'])->name('studytype.store');
  Route::get('studytype/{studytype}/edit',[StudyController::class,'edit'])->name('studytype.edit');
  Route::patch('studytype/{studytype}',[StudyController::class,'update'])->name('studytype.update');
  Route::post('studytype/{studytype}/delete',[StudyController::class,'delete'])->name('studytype.delete');

  Route::get('condition',[ConditionController::class,'index'])->name('condition');
  Route::post('condition',[ConditionController::class,'store'])->name('condition.store');
  Route::get('condition/{condition}/edit',[ConditionController::class,'edit'])->name('condition.edit');
  Route::patch('condition/{condition}',[ConditionController::class,'update'])->name('condition.update');
  Route::post('condition/{condition}/delete',[ConditionController::class,'delete'])->name('condition.delete');

  Route::get('apidetail',[ApiController::class,'index'])->name('apidetail');
  Route::post('apidetail',[ApiController::class,'store'])->name('apidetail.store');
  Route::get('apidetail/{api_detail}/edit',[ApiController::class,'edit'])->name('apidetail.edit');
  Route::patch('apidetail/{api_detail}',[ApiController::class,'update'])->name('apidetail.update');
  Route::post('apidetail/{api_detail}/delete',[ApiController::class,'delete'])->name('apidetail.delete');

  Route::get('product',[ProductController::class,'index'])->name('product');
  Route::get('product/create',[ProductController::class,'create'])->name('product.create');
  Route::post('product',[ProductController::class,'store'])->name('product.store');
  Route::get('product/{product}/edit',[ProductController::class,'edit'])->name('product.edit');
  Route::patch('product/{product}',[ProductController::class,'update'])->name('product.update');
  Route::post('product/{product}/delete',[ProductController::class,'delete'])->name('product.delete');
  Route::get('ajax/product/{product}/details',[ProductController::class,'details'])->name('product.details');

  Route::get('packaging',[PackagingController::class,'index'])->name('packaging');
  Route::post('packaging',[PackagingController::class,'store'])->name('packaging.store');
  Route::get('packaging/{packaging}/edit',[PackagingController::class,'edit'])->name('packaging.edit');
  Route::patch('packaging/{packaging}',[PackagingController::class,'update'])->name('packaging.update');
  Route::post('packaging/{packaging}/delete',[PackagingController::class,'delete'])->name('packaging.delete');

  Route::get('container',[ContainerController::class,'index'])->name('container');
  Route::get('container/create',[ContainerController::class,'create'])->name('container.create');
  Route::post('container',[ContainerController::class,'store'])->name('container.store');
  Route::get('container/{container}/edit',[ContainerController::class,'edit'])->name('container.edit');
  Route::patch('container/{container}',[ContainerController::class,'update'])->name('container.update');
  Route::post('container/{container}/delete',[ContainerController::class,'delete'])->name('container.delete');

  Route::get('test',[TestController::class,'index'])->name('test');
  Route::get('test/create',[TestController::class,'create'])->name('test.create');
  Route::post('test',[TestController::class,'store'])->name('test.store');
  Route::get('test/{test}/edit',[TestController::class,'edit'])->name('test.edit');
  Route::patch('test/{test}',[TestController::class,'update'])->name('test.update');
  Route::post('test/{test}/delete',[TestController::class,'delete'])->name('test.delete');

  Route::get('subtest',[SubtestController::class,'index'])->name('subtest');
  Route::get('subtest/{subtest}/edit',[SubtestController::class,'edit'])->name('subtest.edit');
  Route::patch('subtest/{subtest}',[SubtestController::class,'update'])->name('subtest.update');
  Route::post('subtest/{subtest}/delete',[SubtestController::class,'delete'])->name('subtest.delete');
  
  Route::get('pack',[PackController::class,'index'])->name('pack');
  Route::get('pack/create',[PackController::class,'create'])->name('pack.create');
  Route::post('pack',[PackController::class,'store'])->name('pack.store');
  Route::get('pack/{pack}/edit',[PackController::class,'edit'])->name('pack.edit');
  Route::patch('pack/{pack}',[PackController::class,'update'])->name('pack.update');
  Route::post('pack/{pack}/delete',[PackController::class,'delete'])->name('pack.delete');

  Route::get('batch',[BatchController::class,'index'])->name('batch.index');
  Route::get('batch/create',[BatchController::class,'create'])->name('batch.create');
  Route::post('batch/store',[BatchController::class,'store'])->name('batch.store');
  Route::get('batch/{batch}/edit',[BatchController::class,'edit'])->name('batch.edit');
  Route::patch('batch/{batch}/update',[BatchController::class,'update'])->name('batch.update');
  Route::post('batch/{batch}/delete',[BatchController::class,'delete'])->name('batch.delete');
  Route::get('batch/{batch}/clone',[BatchController::class,'clone'])->name('batch.clone');

});

Route::get('/get/condition',[AjaxController::class,'getCondition'])->name('ajax.condition');
Route::get('/get/test/type',[AjaxController::class,'getTestType'])->name('ajax.test.type');
Route::get('/get/strength',[AjaxController::class,'getProductStrength'])->name('ajax.strength');
Route::get('/get/product',[AjaxController::class,'getProduct'])->name('ajax.get.product');