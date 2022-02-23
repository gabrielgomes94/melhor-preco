<x-layout>
    <x-slot name="navbar">
        <x-app.marketplaces.navbar />
    </x-slot>

    <div class="m-4">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <h2>Marketplaces Integrados</h2>
            </x-slot>

            <x-slot name="body">
                <x-app.marketplaces.list-card.card :marketplaces="$marketplaces" />
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
