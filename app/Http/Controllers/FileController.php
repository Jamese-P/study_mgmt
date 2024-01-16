<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show(){
        $path=public_path('files/');
        $files = \File::files($path);
        natsort($files);
        return view('file')->with(['files'=>$files]);

    }
}
