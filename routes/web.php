<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController,
    ConfirmPasswordController
};
use App\Http\Controllers\Game\{
    InventoryController,
    WorkerController,
    GatherController,
    CraftController,
    FriendController
};
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Public routes
Route::get('/', function () {
    return view('public.home');
})->middleware('guest')->name('home');

// Authorization routes:
Route::get('login', function () {
    return redirect()->route('home');
});
Route::post('login', [LoginController::class, 'login'])->middleware(['throttle:3,10'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware(['auth', 'verifiedfix'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//Game routes
Route::prefix('game')->middleware('verified')->group(function () {
    Route::get('/', function () {
        return redirect()->route('game.workers');
    })->name('game.index');
    Route::middleware('completeTasks')->group(function () {
        Route::get('/inventory', [InventoryController::class, 'show'])->name('game.inventory');
        Route::get('/workers', [WorkerController::class, 'show'])->name('game.workers');
        Route::get('/gather', [GatherController::class, 'show'])->name('game.gather');
        Route::get('/craft', [CraftController::class, 'show'])->name('game.craft');
        Route::prefix('friends')->group(function(){
            Route::get('/', [FriendController::class, 'show'])->name('game.friends');
            Route::get('/friends-table', [FriendController::class, 'friendsTable'])->name('game.friends.friends-table');
        });

    });

    Route::post('/inventory/sell-item',[InventoryController::class, 'sellItem'])->name('game.inventory.sellitem');
    Route::post('/inventory/sell-material',[InventoryController::class, 'sellMaterial'])->name('game.inventory.sellmaterial');
    Route::post('/workers/buy-worker', [WorkerController::class, 'buyWorker'])->name('game.workers.buyworker');
    Route::post('/workers/learns-kill', [WorkerController::class, 'learnSkill'])->name('game.workers.learnskill');
    Route::post('/workers/levelup', [WorkerController::class, 'levelUp'])->name('game.workers.levelup');
    Route::post('/gather/buy-task', [GatherController::class, 'buyTask'])->name('game.gather.buytask');
    Route::post('/gather/stop-task', [GatherController::class, 'stopTask'])->name('game.gather.stoptask');
    Route::post('/gather/start-task', [GatherController::class, 'startTask'])->name('game.gather.starttask');
    Route::post('/craft/start-task', [CraftController::class, 'startTask'])->name('game.craft.starttask');
    Route::post('/craft/stop-task', [CraftController::class, 'stopTask'])->name('game.craft.stoptask');

});

//admin routes
Route::prefix('backend')->middleware(['verified', 'roles:' . User::ROLE_ADMINISTRATOR])->group(function () {
    Route::get('/', function () {
        return "you're in admin";
    })->name('backend.index');
});
