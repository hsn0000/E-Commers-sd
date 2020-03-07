<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use FrontLogin;
use Crypt;
use Session;
use App\Country;
use App\Cart;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function userLoginRegister()
    {
        return view('users.login_register');
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
           if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'] ]))
           {
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



}
