<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', [ProductController::class,'ListProducts']);
Route::get('/index', [ProductController::class,'ListProducts']);
Route::get('/newProd', function () {
    return view('newprod');
});
Route::post('/saveProd', [ProductController::class,'create']);
Route::get('/bills', function () {
    return view('viewbills');
});
Route::get('/newbill', function () {
    return view('newbill');
});
