<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script>
            let darkMode = JSON.parse(localStorage.getItem('dark_mode') ?? 'true');
            let htmlDoc = document.getElementsByTagName( 'html' )[0];
            if (darkMode) {
                htmlDoc.setAttribute('class', 'dark');
            } else {
                htmlDoc.setAttribute('class', '');
            }
            document.addEventListener('dark_mode', () => {
                darkMode = JSON.parse(localStorage.getItem('dark_mode') ?? 'true');
                htmlDoc = document.getElementsByTagName( 'html' )[0];
                if (darkMode) {
                    htmlDoc.setAttribute('class', 'dark');
                } else {
                    htmlDoc.setAttribute('class', '');
                }
            })
        </script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    </head>
    <body class="font-sans antialiased bg-slate-200 dark:bg-slate-500">
        <div>
            {{ $slot }}
        </div>
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        {!! $scripts ?? '' !!}
    </body>
</html>
