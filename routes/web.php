<?php

use App\Http\Controllers\BottelegramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TripayCallbackController;
use App\Http\Controllers\TunnelController;
use App\Http\Controllers\BisnisController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;


Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', HomeController::class)->name('home');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::middleware('permission:create server')->group(function () {
            Route::resource('server', ServerController::class);
            Route::resource('paket', PaketController::class);
            Route::post('tunnels/{tunnel}/deactive', [TunnelController::class, 'removeActive'])->name('tunnels.deactive');
            Route::get('tunnels/async', [TunnelController::class, 'async'])->name('tunnels.async');
            Route::get('tunnels/{tunnel}/sync', [TunnelController::class, 'sync'])->name('tunnels.sync');
            Route::put('tunnels/{tunnel}/reasync', [TunnelController::class, 'reasync'])->name('tunnels.reasync');
            
            
            Route::post('bisnis/{bisni}/deactive', [BisnisController::class, 'removeActive'])->name('bisnis.deactive');
            Route::get('bisnis/async', [BisnisController::class, 'async'])->name('bisnis.async');
            Route::get('bisnis/{bisni}/sync', [BisnisController::class, 'sync'])->name('bisnis.sync');
            Route::put('bisnis/{bisni}/reasync', [BisnisController::class, 'reasync'])->name('bisnis.reasync');
            

            Route::resource('payment', PaymentController::class);

            Route::resource('whatsapp', WhatsappController::class);
            Route::resource('bottelegram', BottelegramController::class);
        });

        Route::resource('user', UserController::class);


        Route::resource('tunnels', TunnelController::class);
        Route::put('tunnels/{tunnel}/renew', [TunnelController::class, 'renew'])->name('tunnels.renew');
        
        Route::resource('bisnis', BisnisController::class);
        Route::put('bisnis/{bisni}/renew', [BisnisController::class, 'renew'])->name('bisnis.renew');

        Route::resource('transaction', TransactionController::class);
        Route::get('transaction/{reference}', [TransactionController::class, 'show'])->name('transaction.show');

        
        Route::post('/bisnis/{bisni}', [BisnisController::class, 'portTambah'])->name('bisnis.addPort');
        Route::delete('/bisnis/{port}/dell', [BisnisController::class, 'portDestroy'])->name('bisnis.dellPort');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
});
Route::post('confirm-payment', [TripayCallbackController::class, 'handle'])->name('payment.callback');
Route::get('log-viewers', [LogViewerController::class, 'index']);
