<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Master\RoomController;
use App\Http\Controllers\Master\AssetController;
use App\Http\Controllers\Report\LogController;
use App\Http\Controllers\Report\ProfitController;
use App\Http\Controllers\Transaction\BillController;
use App\Http\Controllers\Transaction\CheckinController;
use App\Http\Controllers\Transaction\CheckoutController;
use App\Http\Controllers\Setting\UserController;
use App\Http\Controllers\Transaction\PayingController;
use App\Http\Controllers\Report\IncomeController;
use App\Http\Controllers\Report\ExpenseController;
use App\Http\Controllers\Setting\RoomMoveController;
use App\Http\Controllers\Transaction\BuyingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing Page
Route::get('/', function () {
    return view('frontend.welcome');
})->name('/');

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Home
    Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
        Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
    });

    Route::group(['middleware' => ['role:Administrator']], function () {

        Route::get('/home', [DashboardController::class, 'showChart'])->name('dashboard.index');


        // Room
        Route::get('/dashboard/log/data', [LogController::class, 'getData'])->name('dashboard.log.data');
        Route::get('/dashboard/log', [LogController::class, 'index'])->name('log.index');
        // Room
        Route::get('/dashboard/room/data', [RoomController::class, 'getData'])->name('dashboard.room.data');
        Route::get('/dashboard/room', [RoomController::class, 'index'])->name('room.index');
        Route::resource('/dashboard/room', RoomController::class);


        // Aset
        Route::get('/dashboard/asset/data', [AssetController::class, 'getData'])->name('dashboard.asset.data');
        Route::get('/dashboard/asset', [AssetController::class, 'index'])->name('asset.index');
        Route::resource('/dashboard/asset', AssetController::class);

        // Checkin
        Route::get('/dashboard/checkin/data', [CheckinController::class, 'getData'])->name('dashboard.checkin.data');
        Route::get('/dashboard/checkin', [CheckinController::class, 'index'])->name('checkin.index');
        Route::resource('/dashboard/checkin', CheckinController::class);
        

        // Bill
        Route::get('/dashboard/bill/data', [BillController::class, 'getData'])->name('dashboard.bill.data');
        Route::get('/dashboard/bill', [BillController::class, 'index'])->name('bill.index');
        Route::get('/bill/{id}/print', [BillController::class, 'print'])->name('bill.print');
        Route::resource('/dashboard/bill', BillController::class);

         // Checkin
        Route::get('/dashboard/checkout/data', [CheckoutController::class, 'getData'])->name('dashboard.checkout.data');
        Route::get('/dashboard/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::get('/checkin/{id}/print', [CheckinController::class, 'print'])->name('checkin.print');
        Route::resource('/dashboard/checkout', CheckoutController::class);

        // Room
        Route::get('/dashboard/user/data', [UserController::class, 'getData'])->name('dashboard.user.data');
        Route::get('/dashboard/user', [UserController::class, 'index'])->name('user.index');
        Route::resource('/dashboard/user', UserController::class);

        // Paying
        Route::get('/dashboard/paying/data', [PayingController::class, 'getData'])->name('dashboard.paying.data');
        Route::get('/dashboard/paying', [PayingController::class, 'index'])->name('paying.index');
        Route::resource('/dashboard/paying', PayingController::class);

        // Buying
        Route::get('/dashboard/buying/data', [BuyingController::class, 'getData'])->name('dashboard.buying.data');
        Route::get('/dashboard/buying', [BuyingController::class, 'index'])->name('paying.index');
        Route::resource('/dashboard/buying', BuyingController::class);

        // Room Move
        Route::get('/dashboard/roommove/data', [RoomMoveController::class, 'getData'])->name('dashboard.roommove.data');
        Route::get('/dashboard/roommove', [RoomMoveController::class, 'index'])->name('roommove.index');
        Route::resource('/dashboard/roommove', RoomMoveController::class);

        //Income Report
        Route::get('dashboard/income', [IncomeController::class, 'index'])->name('income.index');
        Route::get('dashboard/income/export/', [IncomeController::class, 'export'])->name('income.export');

        Route::get('dashboard/expense', [ExpenseController::class, 'index'])->name('expense.index');
        Route::get('dashboard/expense/export/', [ExpenseController::class, 'export'])->name('expense.export');

        Route::get('dashboard/profit', [ProfitController::class, 'index'])->name('profit.index');


        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::resource('/', \App\Http\Controllers\UserController::class);
        });
    });
});

require __DIR__ . '/auth.php';
