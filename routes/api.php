<?php
use App\Http\Controllers\Api\UserLogin;
use App\Livewire\Demoform;
use App\Livewire\Distributorpage;
use App\Livewire\Distributerorderlist;
use App\Livewire\Productpage;
use App\Livewire\Subcategory;
use App\Livewire\Manageaccount;
use App\Livewire\Userrolepage;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get_porduct', [Productpage::class, 'getproduct']);
Route::get('/get_porductrandom', [Productpage::class, 'getrandomproduct']);
Route::get('/get_productprice', [Productpage::class, 'getprice']);

Route::get('/get_disributer', [Distributorpage::class, 'distributer']);
Route::get('/get_orderlist', [Distributerorderlist::class, 'productorderdata']);

Route::get('/get_demo', [Demoform::class, 'getDemo']);
Route::get('/get_category', [Subcategory::class, 'getcategory']);

Route::get('/get_categorybrand', [Subcategory::class, 'get_category_brand']);

Route::get('/get_categoryvehicle', [Subcategory::class, 'getcategoryvehicle']);

Route::post('/get_order', [Distributerorderlist::class, 'getapporder']);
Route::get('/get_useraccount', [Manageaccount::class, 'getuseraccountdata']);
Route::get('/get_userlogin', [Manageaccount::class, 'userlogindata']);

Route::get('/get_userroles', [Manageaccount::class, 'userroledata']);


Route::get('/get_role', [Userrolepage::class, 'userrole']);

Route::get('/get_productjunction', [Distributerorderlist::class, 'productjunctiondata']);
Route::get('/get_orderhistory', [Distributerorderlist::class, 'orderhistorydata']);

Route::get('/get_hierarchy/{id}', [Distributorpage::class, 'getHierarchy']);
Route::get('/get_all_descendants/{id}', [Distributorpage::class, 'getAllDescendants']);


Route::post('/login', [UserLogin::class, 'userlogin']);
