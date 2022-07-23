<x-layout>
    <x-app.users.navigation selectedNav="marketplaces" />

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="m-4 d-flex justify-content-center">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <h2>Configurar frete - {{ $name }}</h2>
            </x-slot>

            <x-slot name="body">
                <x-app.marketplaces.freight.form
                    :marketplaceSlug="$slug"
                    :freight="$freight"
                />
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
