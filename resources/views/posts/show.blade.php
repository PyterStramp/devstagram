@extends('layouts.app')

@section('titulo')
    {{$post->titulo}}
@endsection

@section('contenido')
    
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{asset('uploads'). "/" . $post->imagen}}" alt="{{$post->titulo}}">

            <div class="p-3 flex items-center gap-4">
                @auth

                    <livewire:like-post :post="$post" />
                @endauth
                
            </div>

            <div class="shadow bg-gray-100 p-5 mb-5">
                <a  href="{{ route('posts.index', $post->user) }}" class="font-bold">{{$post->user->username}}</a>
                <p class="text-sm text-gray-500">{{$post->created_at->diffForHumans()}}</p>
                <p class="mt-5">{{$post->descripcion}}</p>
            </div>

            @auth
                @if ($post->user_id === Auth::user()->id)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Eliminar publicación" class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                    </form>
                @endif
                
            @endauth

        </div>

        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">
                <livewire:comment-post :post="$post" :user="$user">
            </div>
        </div>
        
    </div>
@endsection