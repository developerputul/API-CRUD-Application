<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/putulee', function (Request $request) {
    $search = $request->input('search');

    $sort = $request->input('sort');

    $products = App\Models\Product::query();

    if (!empty($search)) {
        $products->where('id', $search);
    }
    
    $products->orderBy('created_at', $sort);
    
    return response()->json($products->get());
})->name('putulee.route.tutulee');
