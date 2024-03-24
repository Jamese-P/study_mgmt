@extends('layouts.file')

@section('content')
    <div class="file-list">
        <ul>
            @foreach ($files as $file)
                <li>
                    @php
                        $name = substr($file->getfileName(), 0, -3);
                    @endphp
                    <a href="{{ $name }}">{{ $name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
