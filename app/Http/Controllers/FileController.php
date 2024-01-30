<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $text = Storage::get('url.txt');
        $urls = explode("\n",$text);
        return view('file')->with(['urls'=>$urls,'path'=>$path,'files'=>$files]);
    }
}
