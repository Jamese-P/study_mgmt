@extends('layouts.file')
@section('content')
    <div class="file-list">
        @isset($urls)
            <ul>
                @foreach ($urls as $url)
                    <li>{!! $url !!}</li>
                @endforeach
            </ul>
        @endisset

        <ul>
            @foreach ($files as $file)
                @if ($file->getExtension() == 'xlsm' || $file->getExtension() == 'pptx' || $file->getExtension() == 'gslides')
                    <li>
                        <a href="/{{ $path }}/{{ $file->getfileName() }}" download="{{ $file->getfileName() }}">
                            {{ $file->getfileName() }}
                        </a>
                    </li>
                @elseif ($file->getExtension() == 'tex' || $file->getExtension() == 'sh')
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
@endsection
