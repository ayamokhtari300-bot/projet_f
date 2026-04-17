<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-100 h-full">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#020617] bg-gradient-to-br from-[#0b1220] to-[#020617]">
            <div class="mb-8">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-blue-500 hover:scale-110 transition-transform duration-300" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-gray-900/50 backdrop-blur-xl border border-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>

            <!-- Optional: Background Decor -->
            <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-[-1] overflow-hidden">
                <div class="absolute top-[10%] left-[20%] w-72 h-72 bg-blue-600/10 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-[20%] right-[20%] w-96 h-96 bg-indigo-600/10 rounded-full blur-[100px]"></div>
            </div>
        </div>
    </body>
</html>
