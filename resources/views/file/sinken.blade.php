@php
    $names = [
        ['1- 11', '1年11月'],
        ['1-1', '1年1月'],
        ['2- 7', '2年7月'],
        ['2- 11', '2年11月'],
        ['2-1', '2年1月'],
        ['3- 4', '3年4月'],
        ['3- 7', '3年7月'],
        ['3- 10', '3年10月'],
    ];
@endphp

@extends('layouts.file')
@section('content')
    <div style="width:fit-content">
        <p><a href="/md/shinken">一覧ファイル</a></p>
        @foreach ($names as $name)
            <details>
                <summary>{{ $name[1] }}</summary>
                @php
                    $path_pre = public_path($path);
                    $path_pre_count = mb_strlen($path_pre);
                    $files = glob(public_path($path . $name[0] . '*.*'));
                @endphp

                <ul>
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
                </ul>
            </details>
        @endforeach
    </div>
@endsection
