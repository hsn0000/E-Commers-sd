<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use FrontLogin;
use Session;

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

            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'] ]))
            {
                Session::put('frontSession',$data['email']);
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
        return redirect('/');
    }

   
    public function account(Request $request)
    {
        return view('users.account');
    }


    public function checkEmail(Request $request)
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
