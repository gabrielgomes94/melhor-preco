<x-layout>
    <x-slot name="navbar">
        <x-app.marketplaces.navbar />
    </x-slot>

    <div class="row">
        <x-template.alert-messages.alert-messages />
    </div>

    <div class="m-4">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <h2>Cadastrar Marketplace</h2>
            </x-slot>

            <x-slot name="body">
                <x-app.marketplaces.create-form.form />
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
