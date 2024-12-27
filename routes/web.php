<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Employee
Route::get('/employee', [EmployeeController::class, 'index'])->middleware(['auth', 'verified'])->name('employees.index');
Route::post('/employee', [EmployeeController::class, 'store'])->middleware(['auth', 'verified'])->name('employees.store');
Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->middleware(['auth', 'verified'])->name('employees.update');
Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->middleware(['auth', 'verified'])->name('employees.destroy');
// Route Contract
// Route::get('/toqr', [ContractController::class, 'toQr'])->name('contracts.toqr');
// Route::post('/contracts/scan', [ContractController::class, 'storeScannedData'])->name('contracts.scan');

// Route::post('/contracts/generate-qrcode', [ContractController::class, 'generateQRCode'])->name('contracts.generateQr');



// Route QrCode
Route::get('/generate-qrcode/{id}', [QrCodeController::class, 'generateQRCode']);
// Route::get('/toqr', [QrCodeController::class, 'create'])->name('qrcodes.create');
// Route::post('/toqr', [QrCodeController::class, 'store'])->name('qrcodes.store');
Route::get('/qrcode/{id}', [ContractController::class, 'showQRCode'])->name('contracts.qrcode');

Route::get('/generate-qrcode', [QrCodeController::class, 'create'])->name('qrcodes.create');
Route::post('/generate-qrcode', [QrCodeController::class, 'store'])->name('qrcodes.store');
Route::get('/qrcodes/scan', [QRCodeController::class, 'scan'])->name('qrcodes.scan');
Route::post('/qrcodes/save', [QRCodeController::class, 'save'])->name('qrcodes.save');

Route::get('/cancel', function () {
    return redirect()->route('dashboard');
});

Route::get('/contract', [ContractController::class, 'index'])->middleware(['auth', 'verified'])->name('contracts.index');
Route::post('/contract', [ContractController::class, 'store'])->middleware(['auth', 'verified'])->name('contracts.store');
Route::put('/contract/{contract}', [ContractController::class, 'update'])->middleware(['auth', 'verified'])->name('contracts.update');
Route::delete('/contract/{contract}', [ContractController::class, 'destroy'])->middleware(['auth', 'verified'])->name('contracts.destroy');
// Route::get('/contract', [ContractController::class, 'search'])->name('contracts.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
