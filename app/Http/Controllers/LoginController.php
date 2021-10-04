<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        // if(Auth::check()){
        //     return redirect()->route('dashboard');
        // }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'usrname' => 'bail|required|min:4|max:10',
                'passwd'  => 'bail|required|min:4|max:10',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('login')
                            ->withErrors($validator)
                            ->withInput();
            }else{
                $uname = $request->input('usrname');
                $pword = $request->input('passwd');
                $remember = $request->input('remember');
                if (Auth::attempt(['user_name' => $uname, 'password' => $pword, 'active_status' => 1],$remember)) {   
                    return redirect()->intended('dashboard');
                    //return redirect()->route('dashboard')->with('message', 'Success');
                }
                else{
                    return redirect()->route('login')
                    ->with('message', 'Your Username/Password combination was incorrect ')
                    ->withInput();
                }
            }
        }
        return view('login.login', ['errmsg' => ""]);
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function register(Request $request){
        // }
        if ($request->isMethod('post')) {
            $validator = $this->getUserRegisterValidator($request);
            if ($validator->fails()) {
                return redirect()->route('register')
                            ->withErrors($validator)
                            ->withInput();
            }else{
                $user = new User;
                $user->name = $request->input('fname')." ".$request->input('lname');
                $user->user_name = $request->input('uname');
                $user->email =  $request->input('email');
                $user->password = Hash::make($request->input('pass1'));
                $user->active_status = 0;
                $user->save();
                return redirect()->back()->with('succmsg','You have successfully registered. Please contact with System Administrator to activate your account');
                // $terms = $request->input('terms');
            }
        }
        return view('login.register', ['errmsg' => ""]);
    }

    protected function getUserRegisterValidator(Request $request){
        $input = $request->all();
            $rules = [
                'fname'  => 'bail|required|min:4',
                'lname'  => 'bail|required|min:4',
                'email'  => 'bail|required|email|unique:users,email',
                'uname'  => 'bail|required|min:4|max:10|unique:users,user_name',
                'pass1'  => 'bail|required|min:4|max:10',
                'pass2'  => 'bail|required|min:4|max:10|same:pass1',
                'terms'  => 'bail|required',
            ];
            $messages = [
                'fname.required'    => 'Please enter your First Name',
                'lname.required'    => 'Please enter your Last Name',
                'email.required'    => 'Please provide your Email address for better communication',
                'email.unique'      => 'Sorry, This Email address is already used by another user. please try with different one.',
                'uname.required'    => 'Please choose Your User Name',
                'uname.unique'      => 'Sorry, This user name is already used by another user. Please try with different one.',
                'pass1.required'    => 'Password is required for your information safety',
                'pass1.min'         => 'Password length should be more than 4 character',
                'pass2.required'    => 'Please Re-enter your password',
                'pass2.same'        => 'Passwords are not matched',
            ];
            $validator = Validator::make($input, $rules, $messages);
            return $validator;
    }

   
    public function logout(){
        if (Auth::check()){
            Auth::logout();
        }
        return redirect()->route('login');
    }
}
