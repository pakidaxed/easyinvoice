<?php

use App\Http\Controllers\AccountInfoController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('home',[HomeController::class, 'index'])->name('home');

Route::resource('client', ClientController::class);

Route::get('account/edit', [AccountInfoController::class, 'edit'])->name('account.edit');
Route::post('account/edit', [AccountInfoController::class, 'update'])->name('account.update');

Route::resource('invoice', InvoiceController::class);
Route::post('invoice/approve/{id}', [InvoiceController::class, 'isPaid'])->name('invoice.isPaid');
Route::get('invoice/download/{id}', [InvoiceController::class, 'generatePdf'])->name('invoice.download');
