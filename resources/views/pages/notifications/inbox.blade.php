<x-layout>
    <x-slot name="navbar">
        <x-notifications.navbar />
    </x-slot>

    <x-notifications.inbox.card
        :notifications="$inbox->notifications()"
        :mainNotification="$inbox->mainNotification()"
        :paginator="$inbox->paginator()"
    >
    </x-notifications.inbox.card>
</x-layout>
