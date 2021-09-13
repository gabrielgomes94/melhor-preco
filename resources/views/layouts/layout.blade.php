
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


    <!-- Styles -->
    <!-- Main CSS-->
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
