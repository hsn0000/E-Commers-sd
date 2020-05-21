<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Closure;
use Config;
use App;
use Auth;
use FrontLogin;
use Crypt;
use Session;
use App\Country;
use App\Cart;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Excel;
use App\Exports\usersExport;
use Carbon\Carbon;


class UsersController extends Controller
{

    public function __construct() {
         
    }
    

    public function language($locale) {
        // App::setLocale('id');
        Session::put('applocale', $locale);
        if($locale == 'id') {
            $currencyIDR = DB::table('currencies')->where('currency_code','IDR')->first();
            Session::put('currencyLocale',$currencyIDR);
        } else if ($locale == 'en') {
            $currencyUSD = DB::table('currencies')->where('currency_code','USD')->first();
            Session::put('currencyLocale',$currencyUSD);
        }  else if ($locale == 'khmer') {
            $currencyKHR = DB::table('currencies')->where('currency_code','KHR')->first();
            Session::put('currencyLocale',$currencyKHR);
        }
        //  dd( Session::get('currencyIDR')->currency_code );
        return redirect()->back();
    }


    public function userLoginRegister()
    {
        $meta_title ="User Login/Register - E-com Website";
        return view('users.login_register')->with(\compact('meta_title'));
    }


    public function register(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // check if user already exist
            $userCount = User::where('email',$data['email'])->count();
            if($userCount > 0)
            {
                return redirect()->back()->with('signup_error','Email Already Exist !');
            }
            $user = New User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = \bcrypt($data['password']);
            \date_default_timezone_set('asia/jakarta');
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();

            // send registration email
            // $email  = $data['email'];
            // $messageData = ['email' => $data['email'],'name' => $data['name']];
            // Mail::send('emails.register',$messageData, function($message) use($email) {
            //    $message->to($email)->subject('Registration with E-com Husin');
            // });

            // send confirmation email
            $email = $data['email'];
            $messageData = ['email' => $data['email'],'name' => $data['name'], 'code' => base64_encode($data['email'])];
            Mail::send('emails.confirmation',$messageData, function($message) use($email) {
                $message->to($email)->subject('Confirm your E-com Husin Account');
            });

            return redirect()->back()->with('flash_message_success','Please confirm your email to activate your account!');

            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'] ]))
            {
                Session::put('frontSession',$data['email']);
                
                if(!empty(Session::get('session_id')))
                {
                     $session_id = Session::get('session_id');
                     DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]); 
                }

                return redirect('/cart');
            }
            
        }

    }


    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
           if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
           {
               $userStatus = user::where('email', $data['email'])->first();
               if($userStatus->status == 0) {
                   return \redirect()->back()->with('flash_message_error','Your account is not actived ! Please confirm your email to active !');
               }
               Session::put('frontSession',$data['email']);

               if(!empty(Session::get('session_id')))
               {
                    $session_id = Session::get('session_id');
                    DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]); 
               }
               
               return redirect('/cart');
           }else{
               return redirect()->back()->with('flash_message_error','Invalid Username & Password');
           }
        }
    }


    public function forgotPassword(Request $request) {

        if($request->isMethod('post')) {
           $data = $request->all();
           $userCount = DB::table('users')->where('email',$data['email'])->count();
           if($userCount == 0) {
               return redirect()->back()->with('flash_message_error','Email does not Exists !');
           }
         //   get user detail
           $userDetails = DB::table('users')->where('email',$data['email'])->first();
         // generate random password
         $random_password = \str_random(20);
         //  encode /secure password
         $new_password = \bcrypt($random_password);
         //  update password 
         DB::table('users')->where('email',$data['email'])->update(['password' => $new_password]);

         $email = $data['email'];
         $name = $userDetails->name;
         $messageData = [
             'email' => $email,
             'name' => $name,
              'password' => $random_password
            ];
         Mail::send('emails.forgotpassword',$messageData, function($message) use($email) {
                 $message->to($email)->subject('New Password - Husin E-commers');
         });

         return redirect('login-register')->with('flash_message_success',' Please check your email for new password !');

        }
        return view('users.forgot_password');
    }


    public function logout()
    {
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        return redirect('/');
    }

   
    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        if($request->isMethod('post'))
        {
            $data = $request->all();
            $user = User::find($user_id);
            if(empty($data['name']))
            {
                return redirect()->back()->with('flash_message_error','Please Enter Your Name To Update Your Account Details !');
            }
            $user->name = $data['name'] ?? "";
            $user->address = $data['address'] ?? "";
            $user->city = $data['city'] ?? "";
            $user->state = $data['state'] ?? "";
            $user->country = $data['country'] ?? "";
            $user->pincode = $data['pincode'] ?? "";
            $user->mobile = $data['mobile'] ?? "";
            $user->save();
            return redirect()->back()->with('flash_message_success','Your account detail has been successfully updated !');
        }
   
        return view('users.account')->with(\compact('countries','userDetails'));
    }


    public function updatePassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $old_pwd = User::where('id', Auth::user()->id)->first();
            $current_pwd = $data['current_pwd'];
            if(Hash::check($current_pwd, $old_pwd->password))
            {
               // update password
                $new_pwd = \bcrypt($data['new_pwd']);
                User::where('id',Auth::user()->id)->update(['password' => $new_pwd]);
                
                return redirect()->back()->with('signup_success','Password update is successfully !');
            }else{
                return redirect()->back()->with('signup_error','Current password is correct !');
            }

        }
    }


    public function chkUserPassword(Request $request) // cek password user update
    {
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $user_id = Auth::user()->id;
        $check_password = User::where('id', $user_id)->first()->password;
        
        if (Hash::check($current_password, $check_password)){
          return "true";
        }else{
            return "false";
        }
    }


    public function checkEmail(Request $request) // register user
    {
        $data = $request->all();
      // check if user already exist jquery remote
        $userCount = User::where('email',$data['email'])->count();   
        if($userCount > 0)
        {
            echo "false";
        }else{
            echo "true";
        }

    }


    public function confirmAccount($email) {
        $email = \base64_decode($email);
        $userCount =  User::where('email',$email)->count();
        if($userCount > 0) {
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1) {
                return \redirect('login-register')->with('flash_message_success','Your account Email account is already activated. You can login now.');
            } else {
                User::where('email',$email)->update(['status' => 1]);
                // send welcome email
                $messageData = ['email' => $email,'name' => $userDetails->name];
                Mail::send('emails.welcome',$messageData, function($message) use($email) {
                    $message->to($email)->subject('Welcome to E-com Husin');
                });
                return \redirect('login-register')->with('flash_message_success','Your account Email account is activated. You can login now.');
            }
        } else {
            \abort(404);
        }
    }


    public function viewUsers() {
        if(Session::get('adminDetails')['users_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        $users = DB::table('users')->orderBy('created_at','desc')->get();
        return view('admin.users.view_users')->with(\compact('users'));
    }


    public function exportUsers() {
        return Excel::download(new usersExport, 'users.xlsx');
    }


    public function viewUsersCharts() {
        $current_mount_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_mount_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1)->month)->count();
        $last_to_last_mount_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();
        $thre_month_back_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3)->month)->count();
        return view('admin.users.view_users_charts')->with(compact('current_mount_users','last_mount_users','last_to_last_mount_users','thre_month_back_users'));
    }


    public function viewUsersCountriesCharts() {
        $getUserCounties = User::select('country',DB::raw('count(country) as count'))->where('country','!=','')->groupBy('country')->get();
        $getUserCounties = json_decode(json_encode($getUserCounties));

        $getUserCountiesCollecArray = collect();
        foreach($getUserCounties as $countries) {
            $data['y'] = $countries->count;
            $data['name'] = $countries->country;
            $data['exploded'] = true;
            $getUserCountiesCollecArray->push($data);
        }
        // dd($getUserCountiesCollecArray);
        return view('admin.users.view_users_countries_charts')->with(compact('getUserCountiesCollecArray'));
    }



}