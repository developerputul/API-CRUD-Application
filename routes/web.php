<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\ProfileController;
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
Route::redirect('/', '/dashboard');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Admin Dashboard All Route
Route::middleware(['auth',])->group(function(){

    Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',[AdminController::class, 'AdminLogout'])->name('admin.logout');
   
    
//All Category Route
Route::controller(CategoryController::class)->group(function(){
    Route::get('/all/category', 'AllCategory')->name('all.category');
    Route::get('/add/category', 'AddCategory')->name('add.category');
    Route::post('/category/store', 'CategoryStore')->name('category.store');
    Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
    Route::post('/update/category', 'UpdateCategory')->name('update.category');
    Route::get('/delete/category{id}', 'DeleteCategory')->name('delete.category');
});


//All SubCategory Route
Route::controller(SubCategoryController::class)->group(function(){
    Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory');
    Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
    Route::post('/subcategory/store', 'SubCategoryStore')->name('subcategory.store');
    Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
    Route::post('/update/subcategory', 'UpdateSubCategory')->name('update.subcategory');
    Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');
    
    Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory');
});

//Product Manage All Route
Route::controller(ProductController::class)->group(function(){

    Route::get('/all/product', 'AllProduct')->name('all.product');
    Route::get('/add/product', 'AddProduct')->name('add.product');
    Route::post('/store/product', 'StoreProduct')->name('store.product');
    Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
    Route::post('/update/product', 'UpdateProduct')->name('update.product');
    Route::post('/update/product/thambnail', 'UpdateProductThambnail')->name('update.product.thambnail');
    Route::get('/delete/product/{id}', 'ProductDelete')->name('delete.product');

    //test
    Route::get('/all/test', 'AllTest')->name('all.test');
    Route::get('/putulee', 'fetchData')->name('putulee.route');
    
});


}); //End Admin All Group Route
