<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return view('file.index');
    }

    public function show_base()
    {
        $path = public_path('files/');
        $files = File::files($path);
        natsort($files);
        $path = 'files/';

        return view('file.file')->with(['path' => $path, 'files' => $files]);
    }

    public function show_high()
    {
        $path = public_path('high/');
        $files = File::files($path);
        natsort($files);
        $path = 'high/';
        $text = Storage::get('url.txt');
        $text = explode("\n", $text);
        $urls = [];
        for ($i = 0; $i < count($text) - 1; $i = $i + 2) {
            array_push($urls, '<a href="'.$text[$i + 1].'" target="_brank" >'.$text[$i].'</a>');
        }

        return view('file.file')->with(['urls' => $urls, 'path' => $path, 'files' => $files]);
    }

    public function sinken()
    {
        $path = 'sinken/';
        return view('file.sinken')->with(['path' => $path]);
    }

    public function eiken()
    {
        $path = 'eiken/';
        return view('file.eiken')->with(['path' => $path]);
    }
    
    public function center()
    {
        $path = 'center/';
        return view('file.center')->with(['path' => $path]);
    }

    public function tmp()
    {
        $path = public_path('tmp/');
        $files = File::files($path);
        natsort($files);
        $path = 'tmp/';

        return view('file.file')->with(['path' => $path, 'files' => $files]);
    }
}
