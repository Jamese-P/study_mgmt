<!DOCTYPE html>
@php
    $names = [
        ["1- 11","1年11月"],
        ["1-1","1年1月"],
        ["2- 7","2年7月"],
        ["2- 11","2年11月"],
        ["2-1","2年1月"],
        ["3- 4","3年4月"],
        ["3- 7","3年7月"],
        ["3- 10","3年10月"],
        ];
@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $path }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div style="width:fit-content">


        @foreach ($names as $name)
            <details>
                <summary>{{ $name[1] }}</summary>
                @php
                    $path_pre = public_path($path);
                    $path_pre_count = mb_strlen($path_pre);
                    $files = glob(public_path($path . $name[0] . '*.*'));
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
</body>

</html>
