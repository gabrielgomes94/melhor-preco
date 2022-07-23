<x-layout>
    <x-app.users.navigation selectedNav="marketplaces" />

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="m-4 d-flex justify-content-center">
        <div class="col-12">
            <x-bootstrap.card.basic-card>
                <x-slot name="header">
                    <h2>Configurar comissão por categoria</h2>
                </x-slot>

                <x-slot name="body">
                    <x-app.marketplaces.commissions.category-form
                        :categories="$categories"
                        :marketplaceSlug="$marketplaceSlug"
                    />
                </x-slot>
            </x-bootstrap.card.basic-card>
        </div>
    </div>
</x-layout>
