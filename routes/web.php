<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['check.jwt'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/upload', [DashboardController::class, 'uploadFile'])->name('upload');
    Route::get('/manage-account', [DashboardController::class, 'manageAccount'])->name('manage.account');
    Route::get('/view-tables', [DashboardController::class, 'viewTables'])->name('view.tables');
    Route::get('/table/{tableName}', [DashboardController::class, 'viewTableData'])->name('table.data');
    Route::put('/account/update', [DashboardController::class, 'updateAccount'])->name('account.update');
});
