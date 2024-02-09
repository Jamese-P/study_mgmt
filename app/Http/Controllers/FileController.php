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
        $urls = explode("\n", $text);

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
}
