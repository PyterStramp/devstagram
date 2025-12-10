<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    //invoke se manda a llamar automáticamente
    public function __invoke()
    {
        //obtener a quienes seguimos
        $ids = Auth::user()->followings->pluck('id')->toArray();

        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(10);

        return view('home', [
            "posts" => $posts
        ]);
    }
}
