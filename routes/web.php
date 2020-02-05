<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// index page
Route::get('/','IndexController@index');


Route::match(['get','post'],'/admin','AdminController@login');
Route::get('/logout','AdminController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Cataegory / list page
Route::get('/products/{url}','ProductsController@products');
// category detail page
Route::get('/product/{id}','ProductsController@product');
// get product attribute price
Route::get('/get-product-price','ProductsController@getProductPrice');
// add to cart
Route::match(['get','post'],'/admin/add-cart','ProductsController@addtocart');
// cart page
Route::match(['get','post'],'/cart','ProductsController@cart');
// delete product from cart
Route::get('/cart/delete-product-cart/{id}','ProductsController@deleteCartProduct');
// update product quantity in cart
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');
// apply coupon
Route::post('/cart/apply-coupon','ProductsController@applyCoupon');
// register/login page /check-email
Route::get('/login-register','UsersController@userLoginRegister');
// user register form submit
Route::post('/user-register','UsersController@register');
// users logout
Route::get('/user-logout','UsersController@logout');
// users login form submit
Route::post('/user-login','UsersController@login');
// check if user already exist check-email
Route::match(['get','post'],'/check-email','UsersController@checkEmail');

// all route before login
Route::group(['middleware' => ['frontlogin']], function() {
      // user account page
      Route::match(['get','post'],'/account','UsersController@account');
      // check current user password
      Route::post('/check-user-pwd','UsersController@chkUserPassword');
      // update user password
      Route::post('/update-user-pwd','UsersController@updatePassword');
      // user account page
      Route::match(['get','post'],'/checkout','ProductsController@checkout');
      // order review page
      Route::match(['get','post'],'/order-review','ProductsController@orderReview');
      // Place Order
      Route::match(['get','post'],'/place-order','ProductsController@PlaceOrder');
      // thank page
      Route::get('/thanks','ProductsController@thanks');
      // paypal page
      Route::get('/paypal','ProductsController@paypal');
      // user order page
      Route::get('/orders','ProductsController@userOrders');
      // user ordered product page
      Route::get('/orders/{id}','ProductsController@userOrderDetails');
      // Paypal Thank Page
      Route::get('paypal/thanks','ProductsController@thanksPaypal');
      // Paypal Thank Page
      Route::get('paypal/cancel','ProductsController@cancelPaypal');

});

Route::group(['middleware' => ['auth']], function() {
     Route::get('/admin/dashboard','AdminController@dashboard');
     Route::get('/admin/settings','AdminController@settings');
     Route::get('/admin/check-pwd','AdminController@chkPassword');
     Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

    //  Categories Route (Admin)
    Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
    Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
    Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');
    Route::get('/admin/view-categories','CategoryController@viewCategories');

    //  Product Route
    Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
    Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
    Route::get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
    Route::get('/admin/delete-product/{id}','ProductsController@deleteProduct');
    Route::get('/admin/view-product','ProductsController@viewProducts');

    // Products Atributes Route
    Route::match(['get','post'],'/admin/add-attribute/{id}','ProductsController@addAtributes');
    Route::match(['get','post'],'/admin/edit-attribute/{id}','ProductsController@editAtributes');
    Route::get('/admin/delete-attribute/{id}','ProductsController@deleteAttribute');
    Route::match(['get','post'],'/admin/add-images/{id}','ProductsController@addImages');
    Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteAltImage');

    // coupon route
    Route::match(['get','post'],'/admin/add-coupon','CouponsController@addCoupon');
    Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponsController@editCoupon');
    Route::get('/admin/delete-coupon/{id}','CouponsController@deleteCoupons');
    Route::get('/admin/view-coupon','CouponsController@viewCoupons');

    // admin banner route
    Route::match(['get','post'],'/admin/add-banner','BannersController@addBanner');
    Route::match(['get','post'],'/admin/edit-banner/{id}','BannersController@editBanner');
    Route::get('/admin/delete-banner/{id}','BannersController@deleteBanner');
    Route::get('/admin/view-banner','BannersController@viewBanners');
    
    // Admin order view routes
    Route::get('admin/view-orders','ProductsController@viewOrders');
    // Admin order detail routes
    Route::get('admin/view-order/{id}','ProductsController@viewOrderDetails');

});