<x-layout>
    <x-slot name="navbar">
        <x-notifications.navbar />
    </x-slot>

    <x-notifications.inbox.card.card
        :inbox="$inbox"
        :filter="$filter"
    >
    </x-notifications.inbox.card.card>
</x-layout>
