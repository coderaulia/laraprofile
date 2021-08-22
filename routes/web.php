<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// call controller name
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ChangePass;
// call models
use App\Models\Multipic;
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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    $about = DB::table('home_abouts')->first();
    $images = Multipic::all();
    return view('home', compact('brands', 'about', 'images'));
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
Route::get('/brand/edit/{id}', [BrandController::class, 'Edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'Update']);
Route::get('/brand/delete/{id}', [BrandController::class, 'Delete']);

// multi image route
Route::get('/multi/image', [BrandController::class, 'Multipic'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'StoreImg'])->name('store.image');



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    
    // using user models eloquent orm
    // $users = User::all();

    //using query builder
    // $users = DB::table('users')->get();
    
    return view('admin.index');
})->name('dashboard');

Route::get('/user/logout', [BrandController::class, 'logout'])->name('user.logout');

//Slider routes
Route::get('/slider', [HomeController::class, 'HomeSlider'])->name('home.slider');
Route::get('/add/slider', [HomeController::class, 'AddSlider'])->name('add.slider');
Route::post('/store/slider', [HomeController::class, 'StoreSlider'])->name('store.slider');

// About

Route::get('/about', [AboutController::class, 'HomeAbout'])->name('about');
Route::get('/about/add', [AboutController::class, 'AddAbout'])->name('add.about');
Route::post('/about/store', [AboutController::class, 'StoreAbout'])->name('store.about');
Route::get('/about/edit/{id}', [AboutController::class, 'EditAbout']);
Route::post('/about/update/{id}', [AboutController::class, 'UpdateAbout']);
Route::get('/about/delete/{id}', [AboutController::class, 'DeleteAbout']);

//Portfolio Page Route
Route::get('/portfolio', [AboutController::class, 'Portfolio'])->name('portfolio');


// Admin Contact Page Route 
Route::get('/admin/contact', [ContactController::class, 'AdminContact'])->name('admin.contact');
Route::get('/admin/add/contact', [ContactController::class, 'AdminAddContact'])->name('add.contact');
Route::post('/admin/store/contact', [ContactController::class, 'AdminStoreContact'])->name('store.contact');
Route::get('/admin/message', [ContactController::class, 'AdminMessage'])->name('admin.message');


/// Home Contact Page Route 
Route::get('/contact', [ContactController::class, 'Contact'])->name('contact');
Route::post('/contact/form', [ContactController::class, 'ContactForm'])->name('contact.form');


Route::get('/user/password', [ChangePass::class, 'CPassword'])->name('change.password');
Route::post('/password/update', [ChangePass::class, 'UpdatePassword'])->name('password.update');

// User Profile 
Route::get('/user/profile', [ChangePass::class, 'PUpdate'])->name('profile.update');
Route::post('/user/profile/update', [ChangePass::class, 'UpdateProfile'])->name('update.user.profile');
