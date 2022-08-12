<x-layout>
    <x-app.users.navigation selectedNav="marketplaces" />

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="m-4 d-flex justify-content-center">
        <div class="col-12">
            <x-bootstrap.card.basic-card>
                <x-slot name="header">
                    <div class="d-flex justify-content-between">
                        <h2>Configurar comissão por categoria</h2>

                        <x-bootstrap.forms.form.put action="{{ route('categories.sync') }}">
                            <button class="btn btn-primary m-0" type="submit">
                                Sincronizar categorias

                                <x-app.base.icons.icon icon="sync" />
                            </button>
                        </x-bootstrap.forms.form.put>
                    </div>
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
