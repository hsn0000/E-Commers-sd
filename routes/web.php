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

//  lang
Route::get('/language/{locale}','UsersController@language');

// index page
Route::get('/','IndexController@index');

Route::match(['get','post'],'/admin','AdminController@login');
Route::get('/logout','AdminController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Cataegory / list page
Route::get('/products/{url}','ProductsController@products');
/* product filter page */ 
Route::match(['get','post'],'products/filter','ProductsController@filter');
// category detail page
Route::get('/product/{id}','ProductsController@product');
// get product attribute price
Route::post('/get-product-price','ProductsController@getProductPrice');
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
// user forgot-password
Route::match(['get','post'],'forgot-password','UsersController@forgotPassword');
// user register form submit
Route::post('/user-register','UsersController@register');
//confirm account
Route::get('/confirm/{code}','UsersController@confirmAccount');
// users login form submit
Route::post('/user-login','UsersController@login');
// users logout
Route::get('/user-logout','UsersController@logout');
// search product
Route::match(['get','post'],'/search-products','ProductsController@searchProducts');
// check if user already exist check-email
Route::match(['get','post'],'/check-email','UsersController@checkEmail');
// check pincode
Route::match(['get','post'],'/check-pincode','ProductsController@checkPincode');
// check subscriber email
Route::post('/check-subscriber-email','NewsletterController@checkSubscriber');
// add subscriber email
Route::post('/add-subscriber-email','NewsletterController@addSubscriber');
// page url news
Route::get('/topageurlnews','NewsInfoController@topageurlNews'); 

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
      // wish list page
      Route::match(['get','post'],'/wish-list','ProductsController@wishList');
      // delete product from wish list
      Route::get('/wish-list/delete-product/{id}','ProductsController@deleteWishlistProduct');
});

     //payuments
    /*-- skip --*/
    
    // paypal IPN
    Route::post('/paypal/ipn','ProductsController@ipnPaypal');

Route::group(['middleware' => ['adminlogin']], function() { 
      
      Route::get('/admin/dashboard','AdminController@dashboard');
      Route::get('/admin/profile-role','AdminController@profileRole');
      Route::get('/admin/settings','AdminController@settings');
      Route::get('/admin/check-pwd','AdminController@chkPassword'); // matrix from falidate
      Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

      //  Categories Route (Admin)
      Route::match(['get','post'],'/admin/add-categories','CategoryController@addCategory');
      Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
      Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');
      Route::get('/admin/view-categories','CategoryController@viewCategories');

      //  Product Route 
      Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
      Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
      Route::get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
      Route::get('/admin/delete-product-video/{id}','ProductsController@deleteProductVideo');
      Route::get('/admin/delete-product/{id}','ProductsController@deleteProduct');
      Route::get('/admin/view-product','ProductsController@viewProducts');
      Route::get('/admin/export-products','ProductsController@exportProducts'); 

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
      
      //Admin shipping route
      Route::match(['get', 'post'],'/admin/add-billboard','BillboardsController@addBillboard');
      Route::get('/admin/view-billboard','BillboardsController@viewBillboard');
      Route::match(['get','post'],'/admin/edit-billboard/{id}','BillboardsController@editBillboard');
      Route::get('/admin/delete-billboard/{id}','BillboardsController@deleteBillboard');

      // Admin order view route
      Route::get('admin/view-orders','ProductsController@viewOrders');
      //  Admin order chart route 
      Route::get('admin/view-orders-charts','ProductsController@viewOrdersCharts');
      // Admin order detail route
      Route::get('admin/view-order/{id}','ProductsController@viewOrderDetails');
      //     Admin order invoice
      Route::get('/admin/view-order-invoice/{id}','ProductsController@viewOrderInvoice');
      //     Admin order pdf invoice
      Route::get('/admin/view-pdf-invoice/{id}','ProductsController@viewPDFInvoice');
      // Admin order status
      Route::post('admin/update-order-status','ProductsController@updateOrderStatus');
      //  Admin user route 
      Route::get('admin/view-users','UsersController@viewUsers');
      Route::get('/admin/export-users','UsersController@exportUsers'); 
      //  Admin User Chart route 
      Route::get('admin/view-users-charts','UsersController@viewUsersCharts');
      //  Admin User country Chart route 
      Route::get('admin/view-users-countries-charts','UsersController@viewUsersCountriesCharts');
      //  Admin Roles route
      Route::get('/admin/view-admins','AdminController@viewAdmins');
      Route::match(['get', 'post'],'/admin/add-admins','AdminController@addAdmins');
      Route::match(['get', 'post'],'/admin/edit-admins/{id}','AdminController@editAdmins');

      //  admin cms route edit-cms-page 
      Route::match(['get','post'],'/admin/add-cms-page','CmsController@addCmsPage'); 
      Route::get('/admin/view-cms-page','CmsController@viewCmsPage');
      Route::match(['get','post'],'/admin/edit-cms-page/{id}','CmsController@editCmsPage'); 
      Route::get('/admin/delete-cms-page/{id}','CmsController@deleteCmsPage');

      // admin currency route
      Route::match(['get','post'],'/admin/add-currencies','CurrencyController@addCurrency'); 
      Route::match(['get','post'],'/admin/edit-currencies/{id}','CurrencyController@editCurrency'); 
      Route::get('/admin/view-currencies','CurrencyController@viewCurrency');
      Route::get('/admin/delete-currencies/{id}','CurrencyController@deleteCurrency');
      
      //  admin shipping charges
      Route::get('/admin/view-shipping','ShippingController@viewShipping');   
      Route::match(['get','post'],'/admin/edit-shipping/{id}','ShippingController@editShipping'); 

      //  admin newslatter subscriber
      Route::get('/admin/view-newsletter-subscribers','NewsletterController@viewNewsletterSubscribers');   
      Route::get('/admin/update-newsletter-status/{id}/{status}','NewsletterController@updateNewsletterStatus');   
      Route::get('/admin/delete-newslatter-emai/{id}','NewsletterController@deleteNewsletterEmail');
      /*export*/
      Route::get(' /admin/export-newsletter-emails','NewsletterController@exportNewsletterEmail');

      // admin news info
      Route::match(['get','post'],'/admin/add-news','NewsInfoController@addNews');
      Route::match(['get','post'],'/admin/edit-news/{id}','NewsInfoController@editNews');
      Route::get('/admin/view-news','NewsInfoController@viewNews')->name('view-news-info');
      Route::get('/admin/delete-news-info/{id}','NewsInfoController@deleteNews');
      /*ajax*/ 
      Route::get('/admin/edit-status-newsinfo','NewsInfoController@editStatusNews');
      /*end*/

}); 

//  display cms page
Route::match(['get','post'],'/page/{url}','CmsController@cmsPage')->name('page');
//  display contact page
Route::match(['get','post'],'/pages/contact','CmsController@contact');     
// display post page (vue.js)
Route::match(['get','post'],'/page/post','CmsController@addPost');