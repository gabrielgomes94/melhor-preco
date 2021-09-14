
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/volt.css') }}">

    <!-- Scripts -->
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/volt.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <!-- Page Heading -->
        <!-- Sidebar -->
        <x-sidebar>
        </x-sidebar>

        <div class="wrapper">
            <!-- Page Content -->
            <main class="w-100">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <header class="header header-page ">
                                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                    <h2>{{ $header ?? ''}}</h2>
                                </div>
                            </header>
                        </div>
                    </div>
                </div>
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('modals')
</body>
<script>
    @if (Auth::check())
        var tokenApiKey = "{!! env('API_KEY') !!}"
    @endif
</script>
</html>
