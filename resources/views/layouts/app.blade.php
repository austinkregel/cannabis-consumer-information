<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <style>
        [v-cloak] {
            display: none;
        }
    </style>
    </head>
    <body class="font-sans antialiased bg-slate-200 dark:bg-slate-500">
        <div v-cloak class="min-h-screen" id="app" data-user="{{auth()->user()??'null'}}">
            <div class="bg-slate-800 pb-32">

                @include('layouts.navigation')

                <!-- Page Heading -->
                <header class="bg-white dark:bg-slate-700 dark:text-slate-200 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            </div>

            <!-- Page Content -->
            <main class="-mt-32">
                {{ $slot }}
            </main>
            
            <footer class="-mt-12">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 pl-6">
                    <div class="bg-white dark:bg-slate-600 p-8 rounded-lg shadow text-slate-800 dark:text-slate-300">
                        Please note, this website is not associated with any government agency. This is a third-party website that uses public and private crowdsourced data, and is maintained by some guy in Upstate Michigan.
                    </div>
                </div>
            </footer>
        </div>
        <script src="{{ mix('js/app.js') }}" defer></script>
        {!! $scripts !!}
    </body>
</html>
