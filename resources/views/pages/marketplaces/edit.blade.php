<x-layout>
    <x-app.users.navigation selectedNav="marketplaces" />

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="m-4">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <h2>Editar Marketplace {{ $marketplace['name'] }}</h2>
            </x-slot>

            <x-slot name="body">
                <x-app.marketplaces.edit-form.form :marketplace="$marketplace" />
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
