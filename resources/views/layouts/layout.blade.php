
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
        <div class="row">
            <div class="col-sm-2">
                <x-layout.menu.menu />
            </div>

            <div class="col-sm-10">
                <main class="w-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <header class="header header-page ">
                                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-4 lg:px-8">
                                        {{ $header ?? ''}}
                                    </div>
                                </header>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    @stack('modals')
</body>


<script>
    @if (Auth::check())
        var tokenApiKey = "{!! Auth::user()->createToken('token')->plainTextToken  !!}"
    @endif
</script>

</html>
