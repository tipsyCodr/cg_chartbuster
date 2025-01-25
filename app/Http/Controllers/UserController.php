<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        return view('user.login');
    }
    public function create(){
        return view('user.register');
    }

    public function store(Request $request){
        //validating and storing 
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        //creating the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //logging the user in
        auth()->login($user);
        return redirect()->intended('/')->with('success', 'User created successfully');
    }
    public function login(){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials, $request->remember)) {
            return redirect()->intended('/');
        }

        return back()->with('failure', 'Invalid credentials');
    }
    public function logout(){
        auth()->logout();
        return redirect('/');
    }

}
