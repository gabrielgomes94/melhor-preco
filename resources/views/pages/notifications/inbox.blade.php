<x-layout>
    <x-slot name="navbar">
        <x-notifications.navbar />
    </x-slot>

    <x-notifications.inbox
        :notifications="$notifications"
        :mainNotification="$mainNotification"
{{--        :paginator="$paginator"--}}
    >
    </x-notifications.inbox>
</x-layout>
