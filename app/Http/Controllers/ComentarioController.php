<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    
    public function store(User $user, Post $post, Request $request)
    {
        $this->validate($request, [
            'comentario' => ['required', 'max:100']
        ]);

        Comentario::create([
            'user_id' => Auth::user()->id,
            'post_id'=> $post->id,
            'comentario' => $request->comentario
        ]);

        
        return back()->with('mensaje', 'Comentario realizado correctamente');

    }
}
