<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-200 dark:bg-zinc-800">

        {{ $slot }}

        @fluxScripts
    </body>
</html>
