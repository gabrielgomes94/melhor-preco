<x-layout>
    <x-app.users.navigation selectedNav="marketplaces" />

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="col-12">
            <div class="m-4 d-flex justify-content-center">

            </div>
            <x-bootstrap.card.basic-card>
                <x-slot name="header">
                    <h2>{{ $marketplaceName }} - Configurar comissão</h2>
                </x-slot>

                <x-slot name="body">
                    <x-app.marketplaces.commissions.unique-form :marketplaceSlug="$marketplaceSlug" />
                </x-slot>
            </x-bootstrap.card.basic-card>
        </div>
    </div>
</x-layout>
