<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

/////cart////////



Route::get('cart', 'ProductController@cart')->name('cart');
Route::get('add-to-cart/{id}', 'ProductController@addToCart')->name('add.to.cart');
Route::patch('update-cart', 'ProductController@updateCart')->name('update.cart');

Route::delete('remove-from-cart', 'ProductController@removeCart')->name('remove.from.cart');



Auth::routes();

//Route::get('/home', 'HomeController@index');
//
// Route::get('/', 'ProductController@index')->name('home');

Route::get('/', 'ProductController@index')->name('home'); 

Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');

Route::resource('posts', 'PostController');


Route::resource('products', 'ProductController');


Route::post("add_to_cart",'ProductController@addToCart');

//////////

// Route::post("/login",[UserController::class,'login']);
// Route::get("/",[ProductController::class,'index']);
// Route::get("detail/{id}",[ProductController::class,'detail']);
// Route::get("search",[ProductController::class,'search']);

// Route::get("cartlist",[ProductController::class,'cartList']); 
// Route::get("removecart/{id}",[ProductController::class,'removeCart']); 
// Route::get("ordernow",[ProductController::class,'orderNow']); 
// Route::post("orderplace",[ProductController::class,'orderPlace']);
// Route::get("myorders",[ProductController::class,'myOrders']);