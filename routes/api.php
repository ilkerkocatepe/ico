<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum','verified','forbid_banned_user']], function () {

    Route::group(['as' => 'user.','prefix' => 'user'], function () {
        Route::get('/', [App\Http\Controllers\API\UserController::class,'user'])->name('index');
        Route::get('wallet', [App\Http\Controllers\API\UserController::class,'wallet'])->name('wallet');
        Route::post('update', [App\Http\Controllers\API\UserController::class,'update'])->name('update');
    });

    Route::get('stages', [\App\Http\Controllers\API\PurchaseController::class,'stages'])->name('stages');
    Route::get('crypto_gateways', [\App\Http\Controllers\API\PurchaseController::class,'cryptogateways'])->name('cryptogateways');
    Route::get('bank_gateways', [\App\Http\Controllers\API\PurchaseController::class,'bankgateways'])->name('bankgateways');

    Route::group(['as' => 'purchase.','prefix' => 'purchase'], function () {
        Route::get('list', [App\Http\Controllers\API\PurchaseController::class,'list'])->name('list');
        Route::post('store', [App\Http\Controllers\API\PurchaseController::class,'store'])->name('store');
        Route::post('cancel', [App\Http\Controllers\API\PurchaseController::class,'cancel'])->name('cancel');
    });

    Route::group(['as' => 'referral.','prefix' => 'referral'], function () {
       Route::get('status', [App\Http\Controllers\API\ReferenceSystemController::class,'status'])->name('status');
       Route::get('list', [App\Http\Controllers\API\ReferenceSystemController::class,'list'])->name('list');
       Route::get('earnings', [App\Http\Controllers\API\ReferenceSystemController::class,'earnings'])->name('earnings');
    });

    Route::group(['as' => 'external_wallet.','prefix' => 'external_wallet'], function () {
        Route::get('/', [App\Http\Controllers\API\ExternalWalletController::class,'index'])->name('index');
        Route::post('store', [App\Http\Controllers\API\ExternalWalletController::class,'store'])->name('store');
        Route::post('update', [App\Http\Controllers\API\ExternalWalletController::class,'update'])->name('update');
        Route::post('destroy', [App\Http\Controllers\API\ExternalWalletController::class,'destroy'])->name('destroy');
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
