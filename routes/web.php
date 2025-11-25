<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Kabid\KabidLetterController;
use App\Http\Controllers\Kasi\KasiLetterController;
use App\Http\Controllers\Kasi\KasiReportController;
use App\Http\Controllers\Kabid\KabidReportController;
use App\Http\Controllers\Staff\StaffLetterController;
use App\Http\Controllers\Staff\StaffReportController;
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

Route::redirect('/', '/login');

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Home
    Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
        Route::redirect('/', '/login');
        Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
    });

    Route::group(['middleware' => ['role:Administrator']], function () {

        Route::get('/home', [DashboardController::class, 'showChart'])->name('dashboard.index');


        // Room
        Route::get('/dashboard/log/data', [LogController::class, 'getData'])->name('dashboard.log.data');
        Route::get('/dashboard/log', [LogController::class, 'index'])->name('log.index');

        // Route::prefix('dashboard/admin')
        // ->name('admin.')
        // ->group(function () {
        //     Route::get('letter/data', [LetterController::class, 'getData'])
        //         ->name('letter.data');
    
        //     Route::resource('letter', LetterController::class);
        // });

        // Aset
        Route::get('/dashboard/kabid/letter/data', [KabidLetterController::class, 'getData'])->name('dashboard.kabid.letter.data');
        Route::get('/dashboard/kabid/letter', [KabidLetterController::class, 'index'])->name('kabid.letter.index');
        Route::resource('/dashboard/kabid/letter', KabidLetterController::class);

        // Kasi
        Route::get('/dashboard/kasi/letter/data', [KasiLetterController::class, 'getData'])->name('dashboard.kasi.letter.data');
        Route::get('/dashboard/kasi/letter', [KasiLetterController::class, 'index'])->name('kasi.letter.index');
        Route::resource('/dashboard/kasi/letter', KasiLetterController::class);

        // // Staff
        // Route::get('/dashboard/staff/letter/data', [StaffLetterController::class, 'getData'])->name('dashboard.staff.letter.data');
        // Route::get('/dashboard/staff/letter', [StaffLetterController::class, 'index'])->name('staff.letter.index');
        // Route::resource('/dashboard/staff/letter', StaffLetterController::class);

        Route::get('/dashboard/user/data', [UserController::class, 'getData'])->name('dashboard.user.data');
        Route::get('/dashboard/user', [UserController::class, 'index'])->name('user.index');
        Route::resource('/dashboard/user', UserController::class);
        
        Route::get('dashboard/profit', [ProfitController::class, 'index'])->name('profit.index');


        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::resource('/', \App\Http\Controllers\UserController::class);
        });
    });

    Route::group(['middleware' => ['role:Admin|Administrator']], function () {

        Route::get('/home', [DashboardController::class, 'showChart'])->name('dashboard.index');

        Route::prefix('dashboard/admin')
        ->name('admin.')
        ->group(function () {
            Route::get('letter/data', [LetterController::class, 'getData'])
                ->name('letter.data');
    
            Route::resource('letter', LetterController::class);
        });

    });

    
    Route::group(['middleware' => ['role:Kabid|Administrator']], function () {

        Route::get('/home', [DashboardController::class, 'showChart'])->name('dashboard.index');

        Route::prefix('dashboard/kabid')
        ->name('kabid.')
        ->group(function () {
            Route::get('letter/data', [KabidLetterController::class, 'getData'])
                ->name('letter.data');

            Route::resource('letter', KabidLetterController::class);

        });
        Route::prefix('dashboard/kabid')
        ->name('kabid.')
        ->group(function () {
            Route::get('report/data', [KabidReportController::class, 'getData'])
            ->name('report.data');

            Route::resource('report', KabidReportController::class);
        });
        Route::post('/kabid/report/{id}/approve', [KabidReportController::class, 'approve'])
        ->name('kabid.report.approve');  
        
    });

    Route::group(['middleware' => ['role:Kasi|Administrator']], function () {

        Route::get('/home', [DashboardController::class, 'showChart'])->name('dashboard.index');

        Route::prefix('dashboard/kasi')
        ->name('kasi.')
        ->group(function () {
            Route::get('letter/data', [KasiLetterController::class, 'getData'])
                ->name('letter.data');
    
            Route::resource('letter', KasiLetterController::class);
        });  
        Route::prefix('dashboard/kasi')
        ->name('kasi.')
        ->group(function () {
            Route::get('report/data', [KasiReportController::class, 'getData'])
                ->name('report.data');
    
            Route::resource('report', KasiReportController::class);
        });
        // Update laporan
        Route::post('/kasi/report/{id}/approve', [KasiReportController::class, 'approve'])
        ->name('kasi.report.approve');  
    });
    Route::group(['middleware' => ['role:Staff|Administrator']], function () {

        Route::get('/home', [DashboardController::class, 'showChart'])
            ->name('dashboard.index');
    
        Route::prefix('dashboard/staff')
            ->name('staff.')
            ->group(function () {
    
                // Surat untuk staff
                Route::get('letter/data', [StaffLetterController::class, 'getData'])
                    ->name('letter.data');
                Route::resource('letter', StaffLetterController::class);
    
    
                // Datatables laporan
                Route::get('report/data', [StaffReportController::class, 'getData'])
                    ->name('report.data');
    
                // Index laporan
                Route::get('report', [StaffReportController::class, 'index'])
                    ->name('report.index');
    
                // Create laporan → perlu parsing ID surat
                Route::get('report/create/{letter}', [StaffReportController::class, 'create'])
                    ->name('report.create');
    
                // Store laporan
                Route::post('report', [StaffReportController::class, 'store'])
                    ->name('report.store');
    
                // Edit laporan
                Route::get('report/{report}/edit', [StaffReportController::class, 'edit'])
                    ->name('report.edit');
    
                // Update laporan
                Route::put('report/{report}', [StaffReportController::class, 'update'])
                    ->name('report.update');

                                    // Edit laporan
                Route::get('report/{report}/show', [StaffReportController::class, 'show'])
                ->name('report.show');


    
            });
    });
    Route::group(['middleware' => ['role:Kasat|Administrator']], function () {

        Route::get('/home', [DashboardController::class, 'showChart'])->name('dashboard.index');
        Route::get('/dashboard/kasat/log', [LogController::class, 'index'])->name('log.index');

        Route::prefix('dashboard/kasat')
        ->name('kasat.')
        ->group(function () {
            Route::get('letter/data', [KasatLetterController::class, 'getData'])
                ->name('letter.data');
    
            Route::resource('letter', KasatLetterController::class);
        });  
        Route::prefix('dashboard/kasat')
        ->name('kasat.')
        ->group(function () {
            Route::get('report/data', [KasatLetterController::class, 'getData'])
                ->name('report.data');
    
            Route::resource('report', KasatLetterController::class);
        });

    });
    
});

require __DIR__ . '/auth.php';
