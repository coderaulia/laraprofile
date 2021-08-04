<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// call controller name
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
// call models
use App\Models\User;

use Illuminate\Support\Carbon;


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

//category controller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
//Add category
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');
//edit category
Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']);
// delete category
Route::get('softdelete/category/{id}', [CategoryController::class, 'SoftDelete']);
Route::get('pdelete/category/{id}', [CategoryController::class, 'PDelete']);
Route::get('category/restore/{id}', [CategoryController::class, 'Restore']);
//update category
Route::post('/category/update/{id}', [CategoryController::class, 'Update']);

// Brand Route
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'AddBrand'])->name('store.brand');



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    // using user models eloquent orm
    $users = User::all();

    //using query builder
    // $users = DB::table('users')->get();

    return view('dashboard', compact('users'));
})->name('dashboard');