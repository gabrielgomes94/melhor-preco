<x-layout>
    <x-slot name="navbar">
        <x-app.users.navbar />
    </x-slot>

    <div class="m-4">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <div class="d-flex justify-content-between">
                    <h2>Marketplaces Integrados</h2>

                    <x-app.marketplaces.buttons.add-marketplace />
                </div>
            </x-slot>

            <x-slot name="body">
                <x-app.marketplaces.list-card.card :marketplaces="$marketplaces" />
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
