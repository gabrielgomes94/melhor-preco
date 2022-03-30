<x-layout>
    <x-slot name="navbar">
        <x-app.marketplaces.navbar />
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="m-4 d-flex justify-content-center">
        <div class="col-4">
            <x-bootstrap.card.basic-card>
                <x-slot name="header">
                    <h2>Configurar comissão</h2>
                </x-slot>

                <x-slot name="body">
                    <x-app.marketplaces.commissions.unique-form :marketplaceSlug="$marketplaceSlug" />
                </x-slot>
            </x-bootstrap.card.basic-card>
        </div>
    </div>
</x-layout>
