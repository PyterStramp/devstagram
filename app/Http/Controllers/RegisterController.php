<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);
        // Validación
        $this->validate($request, [
            'name'=> ['required', 'max:30'],
            'username'=> ['required', 'unique:users', 'min:3', 'max:20'],
            'email'=> ['required', 'unique:users', 'email', 'max:40'],
            'password'=> ['required', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);

        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        return redirect()->route('posts.index');
    }
}
