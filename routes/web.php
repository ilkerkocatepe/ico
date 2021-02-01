<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use NotificationChannels\Telegram\TelegramMessage;
use Spatie\Permission\Models\Role;

Route::model('external_wallet','App\Models\ExternalWallet');

Route::get('/', function () {
    return view('welcome');
})->name('index');

// Referral Sign up
Route::get('register/{reference?}', function ($reference) {
    return view('auth.register', compact('reference'));
});

// Resending The Verification Email
Route::post('/email/verification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


//  USER
Route::group(['middleware'=>['auth:sanctum', 'verified'],'prefix'=>'user','as'=>'user.'], function (){
    Route::view('dashboard','user.dashboard')->name('dashboard');

    //  Purchase Block
    Route::view('purchase','user.purchase.index')->name('purchase.index');
    Route::view('tokens','user.purchase.tokens')->name('tokens');
    Route::post('purchase/stage',[\App\Http\Controllers\PurchaseController::class,'getStageInfo'])->name('purchase.stage');
    Route::post('purchase/bonus',[\App\Http\Controllers\PurchaseController::class,'getBonusInfo'])->name('purchase.bonus');
    Route::post('purchase/market',[\App\Http\Controllers\PurchaseController::class,'getMarketInfo'])->name('purchase.market');
    Route::any('purchase/preview',[\App\Http\Controllers\PurchaseController::class,'prepare'])->name('purchase.prepare');
    Route::put('purchase/confirm',[\App\Http\Controllers\PurchaseController::class,'confirm'])->name('purchase.confirm');
    Route::put('purchase/cancel',[\App\Http\Controllers\PurchaseController::class,'cancel'])->name('purchase.cancel');

    //  ACCOUNT BLOCK
    Route::view('wallets','user.wallets.index')->name('wallets');
    Route::resource('external-wallets',\App\Http\Controllers\ExternalWalletController::class);
    Route::post('external-wallets/{externalWallet}/enable',[\App\Http\Controllers\ExternalWalletController::class,'enable'])->name('external-wallets.enable');
    Route::post('external-wallets/{externalWallet}/disable',[\App\Http\Controllers\ExternalWalletController::class,'disable'])->name('external-wallets.disable');

    //  PROFILE GROUP
    Route::group(['prefix'=>'profile','as'=>'profile.'], function (){
        //  Profile
        Route::view('/','user.profile.index')->name('index');
        Route::put('password',[\App\Http\Controllers\UserController::class,'updatePassword'])->name('password');
        Route::put('update',[\App\Http\Controllers\UserController::class,'update'])->name('update');
        Route::post('logout-other-devices',[\App\Http\Controllers\UserController::class,'killSessions'])->name('logoutSessions');
        Route::post('enable2fa',[\App\Http\Controllers\UserController::class,'enable2FA'])->name('enable2FA');
        Route::post('disable2fa',[\App\Http\Controllers\UserController::class,'disable2FA'])->name('disable2FA');

        //  Reference System Block
        Route::view('invite-people','user.profile.invite')->name('invite');
        Route::view('earnings','user.profile.earnings')->name('earnings');
        Route::view('referral-tree','user.profile.tree')->name('tree');
    });


});


//  ADMINISTRATOR
$admin = 'futurx';
Route::group(['middleware'=>['auth', 'role:Super Admin|Admin|Editor|Accountant'],'prefix'=>$admin,'as'=>'admin.'], function (){
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::resource('stages',\App\Http\Controllers\StageController::class);

    Route::resource('sells',\App\Http\Controllers\SellController::class);

    Route::resource('crypto-gateways',\App\Http\Controllers\CryptoGatewayController::class);

    Route::post('crypto-pays/confirm',[\App\Http\Controllers\CryptoPayController::class, 'confirmPay'])->name('crypto-pays.confirm');
    Route::post('crypto-pays/reject',[\App\Http\Controllers\CryptoPayController::class, 'rejectPay'])->name('crypto-pays.reject');
    Route::resource('crypto-pays',\App\Http\Controllers\CryptoPayController::class);

    Route::resource('external-wallets',\App\Http\Controllers\ExternalWalletController::class);

    //  USER BLOCK
    Route::resource('users',\App\Http\Controllers\UserController::class);

    //  MISCELLANEOUS
    Route::resource('announcements',\App\Http\Controllers\AnnouncementController::class);

    //  SETTINGS
    Route::get('/up', function () {Artisan::call('up');});
    Route::get('/down', function () {Artisan::call('down --secret="maintenance"'); return redirect()->route('check');});

});
