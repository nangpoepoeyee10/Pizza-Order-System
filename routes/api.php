<?php

use App\Http\Controllers\API\RouteController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'cateoryList']);
Route::get('user/list',[RouteController::class,'userList']);
Route::get('order/list',[RouteController::class,'order']);
Route::get('orderList/list',[RouteController::class,'orderList']);
Route::get('contact/list',[RouteController::class,'contactList']);
Route::get('cart/list',[RouteController::class,'cartList']);

Route::post('create/category',[RouteController::class,'createCategory']);
Route::post('create/contact',[RouteController::class,'createContact']);
Route::get('contact/list',[RouteController::class,'createCategory']);

Route::get('delete/category/{id}',[RouteController::class,'deleteCategory']);
Route::get('category/list/{id}',[RouteController::class,'categoryDetails']);
Route::post('category/update',[RouteController::class,'categoryUpdate']);



// product list
// localhost:8000/api/product/list

// category list
// localhost:8000/api/category/list

// create Category
// localhost:8000/api/create/category

// localhost:8000/api/delete/category/{id} (GET)
// localhost:8000/api/category/list/{id} (GET)
// localhost:8000/api/category/update (POST)





