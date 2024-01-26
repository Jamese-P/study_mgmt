<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show(){
        $path=public_path('files/');
        $files = \File::files($path);
        natsort($files);
        $path = 'files/';
        return view('file')->with(['path'=>$path,'files'=>$files]);
    }

    public function show_high(){
        $path=public_path('high_science/');
        $files = \File::files($path);
        natsort($files);
        $path = 'high_science/';
        return view('file')->with(['path'=>$path,'files'=>$files]);
    }
}
