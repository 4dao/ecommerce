<?php

use App\Http\Controllers\EcommerceController;
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

Route::get('/', [EcommerceController::class, 'index']);



Route::middleware(['auth','can:access-admin'])->group(function () {
    Route::get('/dashboard', function(){
        return view('ecommerce.perfil');
    });
    Route::post('/store', [EcommerceController::class, 'store']);

});

Route::get('/purchase', [EcommerceController::class, 'purchase'])->middleware('auth');

Route::get('/car/{id}', [EcommerceController::class, 'car'])->middleware('auth');
    
Route::get('/finish', [EcommerceController::class, 'finish'])->middleware('auth');


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::match(['get', 'post'], '/pagar/{serial}', [EcommerceController::class, 'pagar'])->name('pagar');

