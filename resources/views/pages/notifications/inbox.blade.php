<x-layout>
    <x-slot name="navbar">
        <x-notifications.navbar />
    </x-slot>

    <x-template.card.card>
        <x-notifications.inbox-card :notifications="$notifications" :mainNotification="$mainNotification" />
    </x-template.card.card>
</x-layout>
