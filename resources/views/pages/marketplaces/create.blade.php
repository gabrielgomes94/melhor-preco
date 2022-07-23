<x-layout>
    <x-app.users.navigation selectedNav="marketplaces" />

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="m-4">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <div class="d-flex justify-content-between">
                    <h2>Cadastrar Marketplace</h2>
                </div>
            </x-slot>

            <x-slot name="body">
                <x-app.marketplaces.create-form.form />
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
