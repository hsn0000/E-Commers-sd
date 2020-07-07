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
            Route::get('/admin/dashboard','DashboardController@index');;
      });

      Route::get('/admin/profile-role','AdminController@profileRole');
      Route::get('/admin/settings','AdminController@settings');
      Route::get('/admin/check-pwd','AdminController@chkPassword'); // matrix from falidate
      Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

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
            Route::get('/admin/export-products','ProductAdminController@exportProducts'); 
            Route::match(['get','post'],'/admin/add','ProductAdminController@addProduct');

            // Products Atributes Route
            Route::match(['get','post'],'/admin/add-images/{id}','ProductAdminController@addImages');
            Route::get('/admin/delete-alt-image/{id}','ProductAdminController@deleteAltImage');
            Route::match(['get','post'],'/admin/add-attribute/{id}','ProductAdminController@addAtributes');
            Route::match(['get','post'],'/admin/edit-attribute/{id}','ProductAdminController@editAtributes');
            Route::get('/admin/delete-attribute/{id}','ProductAdminController@deleteAttribute');
      });

      //  Product Route 

      Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
      Route::get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
      Route::get('/admin/delete-product-video/{id}','ProductsController@deleteProductVideo');
      Route::get('/admin/delete-product/{id}','ProductsController@deleteProduct');
      Route::get('/admin/view-product','ProductsController@viewProducts');


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
      //  Admin User Chart route 
      Route::get('admin/view-users-charts','UsersController@viewUsersCharts');
      //  Admin User country Chart route 
      Route::get('admin/view-users-countries-charts','UsersController@viewUsersCountriesCharts');

  
            Route::prefix('/user')->group(function() 
            {
                  // user route in admin 
                  Route::get('/','UsersAdminController@viewUsers');

                  Route::get('/export-users','UsersAdminController@exportUsers'); 
                  //  Admin User Chart route 
                  Route::get('admin/view-users-charts','UsersController@viewUsersCharts');
                  //  Admin User country Chart route 
                  Route::get('admin/view-users-countries-charts','UsersController@viewUsersCountriesCharts');

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
      // admin inquiries users
      Route::get('/admin/enquiries-list','EnquiriesUsersController@enquiriesList');
      Route::get('/admin/enquiries-outbox','EnquiriesUsersController@enquiriesOutbox');
      Route::get('/admin/delete-enquiries-users/{id}','EnquiriesUsersController@deleteEnquiriesUsers');

      // admin chat route
      Route::match(['get','post'],'/admin/messages','MessagesController@messages')->name('adminMessages');
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