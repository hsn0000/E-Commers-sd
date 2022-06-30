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
Route::post('/cart/update-quantity','ProductsController@updateCartQuantity')->name('cartUpdateQuantity');
// apply coupon
Route::post('/cart/apply-coupon','ProductsController@applyCoupon')->name('applyCoupons');
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
      // front messages route
      Route::match(['get','post'],'front-messages','MessagesController@frontMessages')->name('frontMessages');
      Route::get('/front-message/{id}','MessagesController@frontGetMessage')->name('message');
      Route::post('/front-message','MessagesController@frontSendMessage');
      // ajax upload img
      Route::post('/upload-img-FronMsg','MessagesController@uploadImgFronMsg')->name('uploadImgFron');
      // front notification route
      Route::post('/front-addNotification-message','NotificationMessagesController@addNotificationFrontMessage');
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

      /*ajax read not*/ 
      Route::post('read-notif-messages','NotificationMessagesController@readNotificationMsg')->name('read-notification');
      Route::post('get-notification-data','NotificationMessagesController@getNotificationData')->name('get-notification');
      /*end*/ 
      /*upload photo profile*/
      Route::post('upload-photo-profile','UsersController@uploadPhotoProfile')->name('uploadPhotoProfile');
      /*end*/

      //payuments 
      /*-- skip --*/
      
      // paypal IPN
      Route::post('/paypal/ipn','ProductsController@ipnPaypal'); 

Route::group(['middleware' => ['adminlogin']], function() { 
      
      Route::prefix('/')->group(function() {
            Route::get('/admin/dashboard','DashboardController@index');
      });

      Route::prefix('profile-usr')->group(function() {
            // profile route 
            Route::get('/admin','ProfileUserAdminController@profileRole');
            Route::get('/admin/settings','ProfileUserAdminController@settings');

            Route::get('/admin/check-pwd','ProfileUserAdminController@chkPassword'); // matrix from falidate
            Route::match(['get','post'],'/admin/update-pwd','ProfileUserAdminController@updatePassword');
      });

      Route::prefix('categori')->group(function() {
            //  Categories Route (Admin)
            Route::get('/admin','CategoryController@indexCategories');
            Route::get('/admin/add','CategoryController@addCategory');
            Route::post('/admin/save','CategoryController@saveCategory');
            Route::post('/admin/edit','CategoryController@editCategory');
            Route::post('/admin/update','CategoryController@updateCategory');
            Route::post('/admin/delete','CategoryController@deleteCategory');
      });

      Route::prefix('production')->group(function() { 
            //  Product Route 
            Route::get('/admin','ProductAdminController@indexProducts');
            Route::match(['get','post'],'/admin/add','ProductAdminController@addProduct');
            Route::match(['get','post'],'/admin/edit','ProductAdminController@editProduct');
            Route::post('/admin/update','ProductAdminController@updateProduct');
            Route::get('/admin/delete-product-image/{id}','ProductAdminController@deleteProductImage');
            Route::get('/admin/delete-product-video/{id}','ProductAdminController@deleteProductVideo');
            Route::post('/admin/delete','ProductAdminController@deleteProduct');
            Route::get('/admin/export-products','ProductAdminController@exportProducts'); 

            // Products Atributes Route
            Route::match(['get','post'],'/admin/add-images/{id}','ProductAdminController@addImages');
            Route::get('/admin/delete-alt-image/{id}','ProductAdminController@deleteAltImage');
            Route::match(['get','post'],'/admin/add-attribute/{id}','ProductAdminController@addAtributes');
            Route::match(['get','post'],'/admin/edit-attribute/{id}','ProductAdminController@editAtributes');
            Route::get('/admin/delete-attribute/{id}','ProductAdminController@deleteAttribute');
      });

      Route::prefix('coupons')->group(function() {
            // coupon route
            Route::get('/admin','CouponsController@indexCoupons');
            Route::match(['get','post'],'/admin/add','CouponsController@addCoupon');
            // ajax 
            Route::post('/admin/generate-coupons','CouponsController@generateCoupons');
            
            Route::match(['get','post'],'/admin/edit','CouponsController@editCoupon');
            Route::post('/admin/update','CouponsController@updateCoupons');
            Route::post('/admin/delete','CouponsController@deleteCoupons');   
      });

      Route::prefix('banner')->group(function() {
            // admin banner route
            Route::get('/admin','BannersController@indexBanners');
            Route::match(['get','post'],'/admin/add','BannersController@addBanner');
            Route::match(['get','post'],'/admin/edit','BannersController@editBanner');
            Route::post('/admin/update','BannersController@updateBanner');
            Route::post('/admin/delete','BannersController@deleteBanner');
      });
      
      Route::prefix('billboard')->group(function() {
            //Admin billboard route
            Route::get('/admin','BillboardsController@indexBillboard');
            Route::match(['get', 'post'],'/admin/add','BillboardsController@addBillboard');
            Route::match(['get','post'],'/admin/edit','BillboardsController@editBillboard');
            Route::post('/admin/update','BillboardsController@updateBillboard');
            Route::post('/admin/delete','BillboardsController@deleteBillboard');
      });

      Route::prefix('orders-admin')->group(function() {
            // Admin order view route
            Route::get('/admin','OrderController@indexOrders');     

            // Admin order status
            Route::post('/admin/update-order-status','OrderController@updateOrderStatus');  
            //  Admin order chart route 
            Route::get('/admin/view-orders-charts','OrderController@viewOrdersCharts'); 
      });

      Route::prefix('/user')->group(function() 
      {
            // user route in admin 
            Route::get('/','UsersAdminController@viewUsers');
            //  Admin User Chart & export route 
            Route::get('/export-users','UsersAdminController@exportUsers'); 
            Route::get('/view-users-charts','UsersAdminController@viewUsersCharts');
            Route::get('/view-users-countries-charts','UsersAdminController@viewUsersCountriesCharts');

            //  admin user route 
            Route::get('/admin','AdminController@indexUserAdmin');
            Route::post('/data-table', ['as' => 'userAdmin.dataTable', 'uses' => 'AdminController@dataTable' ]);
            Route::get('/admin/add','AdminController@addUserAdmin');
            Route::post('/admin/save','AdminController@saveUserAdmin');
            Route::match(['get','post'], '/admin/edit','AdminController@editUserAdmin'); 
            Route::post('/admin/update','AdminController@updateUserAdmin');
            Route::post('/admin/delete','AdminController@deleteUserAdmin');
            // ajax
            Route::get('/admin/edit-status-admins','AdminController@editStatusAdmins');
            // user-group route
            Route::get('/group','UserGroupController@indexUserGroup');
            Route::get('/group/add','UserGroupController@userGroupAdd');
            Route::post('/group/save','UserGroupController@userGroupSave');
            Route::match(['get', 'post'],'/group/edit','UserGroupController@userGroupEdit');
            Route::post('/group/update','UserGroupController@userGroupUpdate');
            Route::post('/group/delete','UserGroupController@userGroupDelete');
      });

      Route::prefix('cms-page')->group(function() {
            //  admin cms route edit-cms-page 
            Route::get('/admin','CmsController@indexCmsPage');
            Route::match(['get','post'],'/admin/add','CmsController@addCmsPage'); 
            Route::match(['get','post'],'/admin/edit','CmsController@editCmsPage'); 
            Route::match(['get','post'],'/admin/update','CmsController@updateCmsPage'); 
            Route::POST('/admin/delete','CmsController@deleteCmsPage');
      });

      Route::prefix('currencies')->group(function() {
            // admin currency route
            Route::get('/admin','CurrencyController@indexCurrency');
            Route::match(['get','post'],'/admin/add','CurrencyController@addCurrency'); 
            Route::match(['get','post'],'/admin/edit','CurrencyController@editCurrency'); 
            Route::match(['get','post'],'/admin/update','CurrencyController@updateCurrencies'); 
            Route::post('/admin/delete','CurrencyController@deleteCurrency');
      });
      
      Route::prefix('shipping')->group(function() {
            //  admin shipping charges
            Route::get('/admin','ShippingController@indexShipping');  
            Route::match(['get','post'],'/admin/add','ShippingController@addShipping');  
            Route::match(['get','post'],'/admin/edit','ShippingController@editShipping'); 
            Route::post('/admin/update','ShippingController@updateShipping');
            Route::post('/admin/delete','ShippingController@deleteShipping'); 
      });

      Route::prefix('newsletter-subscribtion')->group(function() {
            //  admin newslatter subscriber
            Route::get('/admin','NewsletterController@indexNewsletterSubscribers');
            // ajax   
            Route::get('/admin/edit-status-newsletter','NewsletterController@editStatusNewsletter')->name('edit-status-newsletter'); 
            // end 
            Route::post('/admin/delete','NewsletterController@deleteNewsletterEmail');
            /*export*/
            Route::get('/admin/export-newsletter-emails','NewsletterController@exportNewsletterEmail');
      });
 
      Route::prefix('news-information')->group(function() {
            // admin news info
            Route::get('/admin','NewsInfoController@indexNews')->name('view-news-info');
            Route::match(['get','post'],'/admin/add','NewsInfoController@addNews');
            Route::match(['get','post'],'/admin/edit','NewsInfoController@editNews');
            Route::match(['get','post'],'/admin/update','NewsInfoController@updateNews');
            Route::post('/admin/delete','NewsInfoController@deleteNews');
            /*ajax*/ 
            Route::get('/admin/edit-status-newsinfo','NewsInfoController@editStatusNews');
            /*end*/
      }); 

      Route::prefix('inquiries')->group(function() {
            // admin inquiries users
            Route::get('/admin','EnquiriesUsersController@indexInquiries');
            Route::get('/admin/delete','EnquiriesUsersController@deleteEnquiriesUsers');
            Route::get('/admin/enquiries-outbox','EnquiriesUsersController@enquiriesOutbox');
      });

      Route::prefix('messages')->group(function() {
            // admin chat route
            Route::match(['get','post'],'/admin/messages','MessagesController@messages')->name('adminMessages');
      });

      Route::prefix('summary-order')->group(function() {
            Route::match(['get','post'],'/admin','SummaryOrderController@index');
            // Admin order invoice
            Route::get('/admin/view-order-invoice/{order_id}','SummaryOrderController@viewOrderInvoice'); 
            // Admin order detail route
            Route::get('/admin/view-order-detail/{order_id}','SummaryOrderController@viewOrderDetails'); 
            // Admin order pdf invoice
            Route::get('/admin/view-pdf-invoice/{id}','SummaryOrderController@viewPDFInvoice');  
      });

      // admin chat route
      Route::get('/admin/message/{id}','MessagesController@getMessage')->name('message');
      Route::post('/admin/message','MessagesController@sendMessage');
      // ajax upload img
      Route::post('/upload-img-AdmMsg','MessagesController@uploadImgAdmMsg')->name('uploadImgAdm');
      // admin notification route
      Route::post('/admin/addNotification-message','NotificationMessagesController@addNotificationMessage');
      
      
}); 

//  display cms page
Route::match(['get','post'],'/page/{url}','CmsController@cmsPage')->name('page');
//  display contact page
Route::match(['get','post'],'/pages/contact','CmsController@contact');     
// display post page (vue.js)
Route::match(['get','post'],'/page/post','CmsController@addPost');