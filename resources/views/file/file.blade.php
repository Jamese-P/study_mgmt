
@extends('layouts.file')
@section('content')
    <div style="width:fit-content">
        @isset($urls)
            @foreach ($urls as $url)
                <a href="{{ $url }}" target="_blank">
                    <p>{{ $url }}</p>
                </a>
            @endforeach
        @endisset

        @foreach ($files as $file)
            @if ($file->getExtension() == 'xlsm' || $file->getExtension() == 'pptx' || $file->getExtension() == 'gslides')
                <a href="/{{ $path }}/{{ $file->getfileName() }}" download="{{ $file->getfileName() }}">
                    <p>{{ $file->getfileName() }}</p>
                </a>
            @else
                <a href="/{{ $path }}/{{ $file->getfileName() }}" target="_blank">
                    <p>{{ $file->getfileName() }}</p>
                </a>
            @endif
        @endforeach
    </div>
@endsection
