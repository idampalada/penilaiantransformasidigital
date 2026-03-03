<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0"
     style="
     background:
     linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
     url('{{ asset('pusdatin.jpeg') }}') no-repeat center center fixed;
     background-size: cover;">
<!-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
     style="
     background:
     linear-gradient(rgba(255,255,255,0.6), rgba(255,255,255,0.6)),
     url('{{ asset('pusdatin.jpeg') }}') no-repeat center center fixed;
     background-size: cover;"> -->


            <!-- Background Overlay -->

            <!-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> -->

<div class="relative z-10 mt-auto mb-12 sm:mb-24 bg-white shadow-md rounded-lg flex flex-col justify-center"
     style="width:450px; min-height:490px;">
    <div class="px-6 py-8">
        {{ $slot }}
    </div>
</div>
        </div>
    </body>
</html>
