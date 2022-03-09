<?php

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

use App\Http\Controllers\GoutteController;

Route::get('/web-scraping', [GoutteController::class, 'doWebScraping'])->name('webscraping');
Route::get('/', function(){
    return view('welcome');
});
