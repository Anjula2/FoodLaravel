<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerRequestController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
]); //->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// })

Route::get('/home',[HomeController::class, 'home']);

route::get('/',[HomeController::class,'index']);

route::post('/addcart/{id}',[HomeController::class,'addcart']);

route::post('/addcartNew/{id}',[HomeController::class,'addcartNew']);

route::get('/cart',[HomeController::class,'cart']);

route::get('/delete/{id}',[HomeController::class,'deletecart']);

Route::post('/orders', [OrderController::class, 'store'])->name('order.store');

Route::get('/myorders',[OrderController::class, 'myorders']);

Route::post('/customer-requests', [CustomerRequestController::class, 'store'])->name('customer.requests.store');
