<!DOCTYPE html>
@php
    $names = [['-2kyu', '2級'], [['2pkyu', 'p2kyu'], '準2級'], ['3kyu', '3級']];
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
                            $file_name = substr($file, 51);
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
