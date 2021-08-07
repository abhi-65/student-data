<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use DB;
use Auth;
use Hash;
use Session;

class UserController extends Controller
{

    public function login(Request $request)
    {
        try
        {
            return view('auth.login');
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }

    public function register(Request $request)
    {
        try
        {
            return view('auth.register');
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }

    public function saveUser(RegisterRequest $registerRequest)
    {
        try
        {
            $this->saveLog(__FUNCTION__,$registerRequest,'Request register user');
            $user = new User();
            $user->first_name = $registerRequest->first_name;
            $user->last_name = $registerRequest->last_name;
            $user->email = $registerRequest->email;
            $user->password = Hash::make($registerRequest->password);
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();
            Auth::login($user);
            return redirect()->route('index');
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }

    public function authenticate(LoginRequest $loginRequest)
    {
        try
        {
            $this->saveLog(__FUNCTION__,$loginRequest,'Request login user');
            $checkUser = User::where('email',$loginRequest->email)->first();
            if(!empty($checkUser))
            {
                if(Hash::check($loginRequest->password,$checkUser->password))
                {
                    Auth::login($checkUser);
                    return redirect()->route('index');
                }
                else
                {
                    Session::flash('message','Invalid Password');
                    return redirect()->back();
                }
            }
            else
            {
                Session::flash('message','Invalid Email');
                return redirect()->back();
            }
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function forgotPassword(Request $request)
    {
        try
        {
            return view('auth.forgot');
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }

    public function checkEmail(Request $request)
    {
        try
        {
            $this->saveLog(__FUNCTION__,$request,'Request check email');
            $checkUser = User::where('email',$request->email)->first();
            if(!empty($checkUser))
            {
                return view('auth.resetpass',compact('checkUser'));
            }
            else
            {
                Session::flash('message','Invalid Email');
                return redirect()->back();
            }
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        try
        {
            $this->saveLog(__FUNCTION__,$request,'Request reset password');
            $checkUser = User::where('id',$request->id)->first();
            if(!empty($checkUser))
            {
                $checkUser->password = Hash::make($request->password);
                $checkUser->save();
                Session::flash('message','Password updated successfully.Login with new password.');
                return redirect()->route('login');
                //return view('auth.resetpass',compact('checkUser'));
            }
            else
            {
                Session::flash('message','User not found');
                return redirect()->back();
            }    
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }
}
