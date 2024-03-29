<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if ( config('app.env') !== 'local')
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        @endif

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/volt.css') }}">

        <!-- Scripts -->
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}" defer></script>
        <script type="text/javascript" src="{{ URL::asset('js/volt.js') }}" defer></script>
    </head>

    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
