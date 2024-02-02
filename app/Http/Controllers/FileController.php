<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(){
        return view('file.index');
    }

    public function show_base(){
        $path=public_path('files/');
        $files = \File::files($path);
        natsort($files);
        $path = 'files/';
        return view('file.file')->with(['path'=>$path,'files'=>$files]);
    }

    public function show_high(){
        $path=public_path('high_science/');
        $files = \File::files($path);
        natsort($files);
        $path = 'high_science/';
        $text = Storage::get('url.txt');
        $urls = explode("\n",$text);
        return view('file.file')->with(['urls'=>$urls,'path'=>$path,'files'=>$files]);
    }

    public function sinken(){
        $path=public_path('sinken/');
        $files = \File::files($path);
        natsort($files);
        $path = 'sinken/';
        return view('file.file')->with(['path'=>$path,'files'=>$files]);
    }

    public function eiken(){
        $path = 'eiken/';
        $path2=public_path($path);
        $files = \File::files($path2);
        natsort($files);
        return view('file.file')->with(['path'=>$path,'files'=>$files]);
    }
}
