<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request){ //setiap nembak data request harus kasih ini
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email:dns',
            'password' => 'required',
            'gender' => 'required',
            'role' => 'required'
        ]);

        $validate['password'] = bcrypt($validate['password']);

        User::create($validate);

        return redirect('/login')->with('registerSuccess', 'Registration Succes, Please Login!');

    }

    public function login(Request $request){
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // kalo betul ada credentialnya
        if(Auth::attempt($validate)){
            $request->session()->regenerate();

            $role = auth()->user()->role;

            if($role == 'developer'){
                return redirect('/developer');
            }else{
                return redirect('/buyer');
            }

        }

        return redirect()->back()->with('loginError', "Login failed!");
    }

    public function logout(){
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');

    }
}
