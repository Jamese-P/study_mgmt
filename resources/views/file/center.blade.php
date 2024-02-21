@extends('layouts.file')
@section('content')
    <div class="file-list">
        <details>
            <summary>国語</summary>
            <ul>
                @php
                    $path_tmp = $path . 'japanese/';
                    $path_pre = public_path($path_tmp);
                    $path_pre_count = mb_strlen($path_pre);
                    $files = File::files(public_path($path_tmp));
                @endphp
                @foreach ($files as $file)
                    @php
                        $file_name = substr($file, $path_pre_count);
                    @endphp
                    <li>
                        <a href="/{{ $path_tmp }}{{ $file_name }}" target="_blank">
                            {{ $file_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </details>
        <details>
            <summary>英語</summary>
            <ul>
                @php
                    $path_tmp = $path . 'english/';
                    $path_pre = public_path($path_tmp);
                    $path_pre_count = mb_strlen($path_pre);
                    $files = File::files(public_path($path_tmp));
                @endphp
                @foreach ($files as $file)
                    @php
                        $file_name = substr($file, $path_pre_count);
                    @endphp
                    <li>
                        <a href="/{{ $path_tmp }}{{ $file_name }}" target="_blank">
                            {{ $file_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </details>

    </div>
@endsection
