<?php

use Illuminate\Support\Facades\Route;

// call controller name
use App\Http\Controllers\ContactController;
// call models
use App\Models\User;

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
    return view('welcome');
});

Route::get('/home', function () {
    echo "Homepage!";
});

Route::get('/about', function () {
    return view ('about');
});

//using controller
Route::get('/contact', [ContactController::class, 'index'])->name('con');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    // using user models
    $users = User::all();
    return view('dashboard', compact('users'));
})->name('dashboard');