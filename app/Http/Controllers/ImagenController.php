<?php

namespace App\Http\Controllers;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {

        $img = $request->file('file');

        $nombreImg = Str::uuid() . "." . $img->extension();

        $manager = new ImageManager(new Driver());

        $imgServidor = $manager::gd()->read($img);

        $imgServidor->cover(1000, 1000);
        
        $imgPath = public_path('uploads') . "/" . $nombreImg;

        $imgServidor->save($imgPath);

        return response()->json(['img' => $nombreImg]);
    }
}
