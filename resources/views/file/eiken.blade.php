@php
    $names = [['-2kyu', '2級'], [['2pkyu', 'p2kyu'], '準2級'], ['3kyu', '3級']];
@endphp

@extends('layouts.file')

@section('content')
    <div style="width:fit-content">
        @foreach ($names as $name)
            <details>
                <summary>{{ $name[1] }}</summary>
                @php
                    $path_pre = public_path($path);
                    $path_pre_count = mb_strlen($path_pre);
                    if (is_array($name[0])) {
                        $files = null;
                        foreach ($name[0] as $tmp) {
                            $files_tmp = glob(public_path('eiken/*' . $tmp . '*.*'));
                            if (is_null($files)) {
                                $files = $files_tmp;
                            } else {
                                $files = array_merge($files, $files_tmp);
                            }
                        }
                    } else {
                        $files = glob(public_path('eiken/*' . $name[0] . '*.*'));
                    }
                    natsort($files);
                @endphp
                <lu>
                    @foreach ($files as $file)
                        @php
                            $file_name = substr($file, $path_pre_count);
                        @endphp
                        <li>
                            <a href="/{{ $path }}/{{ $file_name }}" target="_blank">
                                {{ $file_name }}
                            </a>
                        </li>
                    @endforeach
                </lu>
            </details>
        @endforeach
    </div>
@endsection
