<x-layout>
    <x-app.users.navigation selectedNav="marketplaces" />

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="d-flex m-2">
            <x-bootstrap.card.basic-card>
                <x-slot name="header">
                    <h2>Configurar frete - {{ $name }}</h2>
                </x-slot>

                <x-slot name="body">
                    <x-app.marketplaces.freight.form
                        :marketplaceSlug="$slug"
                        :freight="$freight"
                    />

                    <div class="mt-2">
                        <h3>Tabela de Frete</h3>
                        <x-app.marketplaces.freight.table.table :freightTable="$freightTable" />
                    </div>
                </x-slot>
            </x-bootstrap.card.basic-card>
        </div>
    </div>
</x-layout>
