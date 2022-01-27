<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {return view('welcome');} );
//Frontend Controllers
Route::get('/', 'FrontendController@index');
Route::get('product/details/{slug}', 'FrontendController@productdetails');
Route::get('contact', 'FrontendController@contact');
Route::post('contact/insert', 'FrontendController@contactinsert');
Route::get('about', 'FrontendController@about');
Route::get('shop', 'FrontendController@shop');
Route::get('customer/register', 'FrontendController@customerregister');
Route::post('customer/register/post', 'FrontendController@customerregisterpost');
//Auth Controllers
Auth::routes(['verify' => true]);
//Home Controllers
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('send/newsletter', 'HomeController@sendnewsletter')->name('home');
Route::get('contact/upload/download/{contact_id}', 'HomeController@contactuploaddownload');
//Category Controllers
Route::get('add/category', 'CategoryController@addcategory');
Route::post('add/category/post', 'CategoryController@addcategorypost');
Route::get('delete/category/{category_id}', 'CategoryController@deletecategory');
Route::get('edit/category/{category_id}', 'CategoryController@editcategory');
Route::post('edit/category/post', 'CategoryController@editcategorypost');
Route::get('restore/category/{category_id}', 'CategoryController@restorecategory');
Route::get('force/delete/category/{category_id}', 'CategoryController@forcedeletecategory');
Route::post('mark/delete', 'CategoryController@markdelete');
Route::post('mark/restore', 'CategoryController@markrestore');
// Profile Controller
Route::get('profile', 'ProfileController@profile');
Route::post('edit/profile', 'ProfileController@editprofilepost');
Route::post('edit/password', 'ProfileController@editpasswordpost');
Route::post('change/profile/photo', 'ProfileController@changeprofilephoto');
// Product Controller
Route::resource('product', 'ProductController');
Route::post('mark/delete/product', 'ProductController@markdelete')->name('mark.delete.product');
Route::post('mark/restore/product', 'ProductController@markrestore')->name('mark.resote.product');
// Cart Controller
Route::get('cart','CartController@index')->name('cart.index');
Route::get('cart/{coupon_name}','CartController@index')->name('cart.shuvo');
Route::post('cart/store','CartController@store')->name('cart.store');
Route::post('cart/update','CartController@update')->name('cart.update');
Route::get('cart/remove/{cart_id}','CartController@remove')->name('cart.remove');
// test perpose
Route::get('fox/forhad','ForhadController@forhad');
// Coupon Controller
Route::resource('coupon', 'CouponController');
// Customer Controller
Route::get('customer/home', 'CustomerController@home');
//github controller
Route::get('login/github', 'GithubController@redirectToProvider');
Route::get('login/github/callback', 'GithubController@handleProviderCallback');
//checkout controller
Route::get('checkout','CheckoutController@index')->name('checkout.index');
Route::post('checkout/post','CheckoutController@checkoutpost')->name('checkout.post');
Route::post('/get/city/list/ajax','CheckoutController@getcitylistajax')->name('citylist.post');
