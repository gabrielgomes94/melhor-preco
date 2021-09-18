
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

<body>
    <x-layout.menu.menu />

    <main class="content">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-start">
                    <div class="d-block">
                        {{--                        <x-layout.menu.menu-toggle />--}}
                    </div>
                    {{ $navbar ?? ''}}
                </div>
            </div>

            <div class="col-12">
                @isset($header)
                    <header class="header header-page py-4">
                        <div class="mx-auto">
                            <h2 class="display-3    "> {{ $header ?? ''}}</h2>
                        </div>
                    </header>
                @endisset
            </div>

            <div class="col-12">
                <div class="mx-auto">
                    {{ $breadcrumb ?? '' }}
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{ $modals ?? '' }}
</body>

<script>
    @if (Auth::check())
        var tokenApiKey = "{!! Auth::user()->createToken('token')->plainTextToken  !!}"
    @endif
</script>

</html>
