<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <x-layout.head.head />
    </head>

    <body>
        <x-layout.content.content
            :navbar="$navbar ?? null"
            :header="$header ?? null"
            :breadcrumb="$breadcrumb ?? null"
        >
            {{ $slot }}
        </x-layout.content.content>

        {{ $modals ?? '' }}
    </body>

    <x-layout.js.api-token />
</html>
