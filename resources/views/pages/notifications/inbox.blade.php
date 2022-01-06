<x-layout>
    <x-slot name="navbar">
        <x-app.notifications.navbar />
    </x-slot>

    <x-app.notifications.inbox.card.card
        :inbox="$inbox"
        :filter="$filter"
    >
    </x-app.notifications.inbox.card.card>
</x-layout>
