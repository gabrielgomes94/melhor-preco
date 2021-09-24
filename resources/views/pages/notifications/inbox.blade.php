<x-layout>
    <x-slot name="navbar">
        <x-notifications.navbar />
    </x-slot>

    <x-notifications.inbox.card
        :notifications="$notifications"
        :mainNotification="$mainNotification"
        :paginator="$paginator"
    >

    </x-notifications.inbox.card>
</x-layout>
