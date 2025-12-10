<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    //
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,'.Auth::user()->id, 'min:3', 'max:20', 'not_in:editar-perfil'],
            'email'=> ['required', 'unique:users,email,'.Auth::user()->id, 'email', 'max:40'],
            'password'=> ['required', 'confirmed'],
            'oldpassword'=> ['required']
        ]);

        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->oldpassword])) {
            return back()->with('mensaje', 'Credenciales incorrectas');
        }

        if($request->imagen) {
            $img = $request->file('imagen');

            $nombreImg = Str::uuid() . "." . $img->extension();

            $manager = new ImageManager(new Driver());

            $imgServidor = $manager::gd()->read($img);
            $imgServidor->cover(1000, 1000);
        
            $imgPath = public_path('perfiles') . "/" . $nombreImg;

            $imgServidor->save($imgPath);
            
        }

        $usuario = User::find(Auth::user()->id);

        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImg ?? Auth::user()->imagen ?? null;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('posts.index', $usuario);

    }
}
