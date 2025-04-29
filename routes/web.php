<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\WorkShiftController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\SalaryController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create-account', [UserController::class, 'create'])->name('employees.create-account');
    Route::post('/employees/create-account', [UserController::class, 'store'])->name('employees.store-account');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    // Work Shifts
    Route::resource('work-shifts', WorkShiftController::class);

    // Attendances
    Route::resource('attendances', AttendanceController::class);
    Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.checkIn');
    Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.checkOut');

    // Inventories
    Route::resource('inventories', InventoryController::class);

    // Restocks
    Route::resource('restocks', RestockController::class);
    Route::put('/restocks/{id}/update-status', [RestockController::class, 'updateStatus'])->name('restocks.update-status');

    Route::prefix('jurnal')->group(function () {
        Route::get('/', [JurnalController::class, 'month'])->name('jurnal.month');
        Route::get('/{monthYear}', [JurnalController::class, 'index'])->name('jurnal.index');
        Route::get('/{monthYear}/create', [JurnalController::class, 'create'])->name('jurnal.create');
        Route::post('/', [JurnalController::class, 'store'])->name('jurnal.store');
        Route::get('/{jurnal}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
        Route::put('/{jurnal}', [JurnalController::class, 'update'])->name('jurnal.update');
        Route::delete('/{jurnal}', [JurnalController::class, 'destroy'])->name('jurnal.destroy');
    });

    Route::prefix('penggajian')->group(function () {
        Route::get('/', [SalaryController::class, 'month'])->name('penggajian.month');
        Route::get('/{monthYear}', [SalaryController::class, 'index'])->name('penggajian.index');
        Route::get('/{monthYear}/create', [SalaryController::class, 'create'])->name('penggajian.create');
        Route::post('/', [SalaryController::class, 'store'])->name('penggajian.store');
        Route::get('/{salary}/edit', [SalaryController::class, 'edit'])->name('penggajian.edit');
        Route::put('/{salary}', [SalaryController::class, 'update'])->name('penggajian.update');
        Route::delete('/{salary}', [SalaryController::class, 'destroy'])->name('penggajian.destroy');
    });
});
