<?php

use App\Models\Sell;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
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

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('user.dashboard')->with(['success' => 'Your e-mail verified successfully!']);
})->name('verification.verify');

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
        Route::get('read-notifications',[\App\Http\Controllers\UserController::class,'readAllNotifications'])->name('read.notifications');

        //  LAYOUT
        Route::post('switchLight',[\App\Http\Controllers\UserController::class,'switchLight'])->name('switchLight');
        Route::post('switchDark',[\App\Http\Controllers\UserController::class,'switchDark'])->name('switchDark');

        //  Reference System Block
        Route::view('invite-people','user.profile.invite')->name('invite');
        Route::view('earnings','user.profile.earnings')->name('earnings');
        Route::view('referral-tree','user.profile.tree')->name('tree');
    });


});


//  ADMINISTRATOR
$admin = 'futurx';
Route::group(['middleware'=>['auth', 'role:Super Admin|Admin|Editor|Accountant'],'prefix' => $admin,'as' => 'admin.'], function (){
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::resource('stages',\App\Http\Controllers\StageController::class);

    Route::resource('sells',\App\Http\Controllers\SellController::class);

    Route::resource('crypto-gateways',\App\Http\Controllers\CryptoGatewayController::class);
    Route::resource('bank-gateways',\App\Http\Controllers\BankGatewayController::class);

    Route::post('crypto-pays/confirm',[\App\Http\Controllers\CryptoPayController::class, 'confirmPay'])->name('crypto-pays.confirm');
    Route::post('crypto-pays/reject',[\App\Http\Controllers\CryptoPayController::class, 'rejectPay'])->name('crypto-pays.reject');
    Route::resource('crypto-pays',\App\Http\Controllers\CryptoPayController::class);

    Route::post('bank-pays/confirm',[\App\Http\Controllers\BankPayController::class,'confirm'])->name('bank-pays.confirm');
    Route::get('bank-pays/cancel/{sell_id}',[\App\Http\Controllers\BankPayController::class,'cancel'])->name('bank-pays.cancel');
    Route::resource('bank-pays',\App\Http\Controllers\BankPayController::class);

    Route::resource('external-wallets',\App\Http\Controllers\ExternalWalletController::class);

    //  USER BLOCK
    Route::resource('users',\App\Http\Controllers\UserController::class);
    Route::put('user/update/{user}',[\App\Http\Controllers\UserController::class,'updateFromAdmin'])->name('user.update');
    Route::get('assign/{user}/{role}',[\App\Http\Controllers\UserController::class,'assign'])->name('assign');
    Route::get('unassign/{user}/{role}',[\App\Http\Controllers\UserController::class,'unassign'])->name('unassign');
    Route::get('ban/{user}',[\App\Http\Controllers\UserController::class,'ban'])->name('ban');
    Route::get('unban/{user}',[\App\Http\Controllers\UserController::class,'unban'])->name('unban');
    Route::get('verify/{user}',[\App\Http\Controllers\UserController::class,'verify'])->name('verify');

    //  MISCELLANEOUS
    Route::resource('announcements',\App\Http\Controllers\AnnouncementController::class);

    //  SETTINGS
    Route::get('/up', function () {Artisan::call('up');});
    Route::get('/down', function () {Artisan::call('down --secret="maintenance"'); return redirect()->route('check');});

});
