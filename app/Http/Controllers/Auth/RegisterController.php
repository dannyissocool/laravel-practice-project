<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request) {
        // validation
        //dd($request->email); //dd($request->get('email')) === shorthand 
        $this-> validate($request, [
            'name' => ['required', 'max:255'],
            'username' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed',
        ]);

       

        
        // store user
         User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);
        // sign the user in
        auth()->user(); // returns current User or null
        auth()->attempt($request->only('email', 'password'));
        // redirect
        return redirect()->route('dashboard');
    }
}
