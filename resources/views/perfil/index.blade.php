@extends('layouts.app')

@section('titulo')
    
    Editar perfil: {{ Auth::user()->username }}

@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form action="{{ route('perfil.store') }}" method="post" class="mt-10 md:mt-0" enctype="multipart/form-data">
                @csrf

                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}</p>
                @endif

                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Username</label>
                    <input id="username" name="username" type="text" placeholder="Cambia tu username" class="border p-3 w-full rounded-lg @error('username')
                        border-red-500 
                    @enderror" value={{ Auth::user()->username }}>
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input id="email" name="email" type="email" placeholder="Cambia tu correo" class="border p-3 w-full rounded-lg  @error('email')
                        border-red-500 
                    @enderror" value={{ Auth::user()->email }}>
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror                    
                </div>
                
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Nueva Password</label>
                    <input id="password" name="password" type="password" placeholder="Tu nueva contraseña" class="border p-3 w-full rounded-lg  @error('password')
                        border-red-500 
                    @enderror">
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror                    
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">Repetir nueva Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Repite la nueva contraseña" class="border p-3 w-full rounded-lg">
                </div>

                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold cursor-pointer">Imagen perfil</label>
                    <input id="imagen" name="imagen" type="file" accept=".jpg, .jpeg, .png, .webp" class="border p-3 w-full rounded-lg">
                </div>

                <div class="mb-5">
                    <label for="oldpassword" class="mb-2 block uppercase text-gray-500 font-bold">Ingresa tu contraseña actual para confirmar estos cambios</label>
                    <input id="oldpassword" name="oldpassword" type="password" placeholder="Tu contraseña actual" class="border p-3 w-full rounded-lg  @error('oldpassword')
                        border-red-500 
                    @enderror">
                    @error('oldpassword')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror                    
                </div>

                <input type="submit" value="Guardar cambios" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
        <div>
            
        </div>        
    </div>    
@endsection
