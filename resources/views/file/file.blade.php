
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

        <div class="file-list">
            <ul>



        @foreach ($files as $file)
            @if ($file->getExtension() == 'xlsm' || $file->getExtension() == 'pptx' || $file->getExtension() == 'gslides')
                <li>
                <a href="/{{ $path }}/{{ $file->getfileName() }}" download="{{ $file->getfileName() }}">
                    {{ $file->getfileName() }}
                </a>
                </li>
            @else
            <li>
                <a href="/{{ $path }}/{{ $file->getfileName() }}" target="_blank">
                    {{ $file->getfileName() }}
                </a>
                </li>
            @endif
        @endforeach
        </ul>
        </div>
    </div>
@endsection
