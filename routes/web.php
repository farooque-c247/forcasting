<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KeapController;

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


Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::middleware(['auth'])->group(function(){
Route::get('/home', function () {
    return view('index');
})->name('keap.webpage');
Route::get('/home', function () {
    return view('index');
});
Route::POST("/keap/import", [KeapController::class, "import"])->name('keap.import');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::fallback(function ()
{
    abort(404);
});
