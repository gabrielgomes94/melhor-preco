<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <x-app.base.head.head />
    </head>

    <body>
        <x-app.base.content.content
            :navbar="$navbar ?? null"
            :header="$header ?? null"
            :breadcrumb="$breadcrumb ?? null"
        >
            {{ $slot }}
        </x-app.base.content.content>

        {{ $modals ?? '' }}
    </body>

    <x-app.base.js.api-token />
</html>
