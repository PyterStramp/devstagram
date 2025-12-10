<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\AssignOp\Pow;

class PostController extends Controller
{
    //
    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(10);
        
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => ['required', 'max:40'],
            'descripcion' => ['required', 'max:70'],
            'imagen' => ['required']
        ]);

        /*
        Post::create([
            "titulo" => $request->titulo,
            "descripcion" => $request->descripcion,
            "imagen" => $request->imagen,
            "user_id" => Auth::user()->id,
        ]);
        */
        //otra forma
        /*
        $post = new Post;
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = Auth::user()->id;
        $post->save();
        */

        //guardar una relacion post

        $request->user()->posts()->create([
            "titulo" => $request->titulo,
            "descripcion" => $request->descripcion,
            "imagen" => $request->imagen,
            "user_id" => Auth::user()->id,
        ]);

        return redirect()->route('posts.index', [
            "user" => Auth::getUser()
        ]);
    }

    public function show (User $user, Post $post)
    {
        return view('posts.show', [
            "post" => $post,
            "user"=> $user
        ]);
    }

    public function destroy(Post $post)
    {
        Gate::allows('delete', $post);       

        $post->delete();

        $imgPath = public_path('uploads/' . $post->imagen);

        if (File::exists($imgPath)) {
            unlink($imgPath);
            
        }

        return redirect()->route('posts.index', [
            "user" => Auth::getUser()
        ]);
    }
}
