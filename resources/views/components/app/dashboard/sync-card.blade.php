<x-template.card.card>
    <x-template.card.card-body>
        <div class="sync-card-product p-1 border-bottom">
            <div class="d-inline-flex justify-content-between w-100">
                <x-app.dashboard.sync-card.info-label
                    label="Produtos Sincronizados"
                    :value="$data['products']['syncedQuantity']"
                />
            </div>

            <div class="d-inline-flex justify-content-between w-100">
                <x-app.dashboard.sync-card.info-label
                    label="Produtos Ativos"
                    :value="$data['products']['activeQuantity']"
                />
            </div>

            <div class="d-inline-flex justify-content-between w-100">
                <x-app.dashboard.sync-card.timestamp-label :date="$data['products']['lastUpdatedAt']" />
            </div>
        </div>

        <div class="sync-card-invoices p-1 border-bottom">
            <div class="d-inline-flex justify-content-between w-100">
                <x-app.dashboard.sync-card.info-label
                    label="Notas Fiscais de Compra"
                    :value="$data['invoices']['syncedQuantity']"
                />
            </div>

            <div class="d-inline-flex justify-content-between w-100">
                <x-app.dashboard.sync-card.timestamp-label :date="$data['invoices']['lastUpdatedAt']" />
            </div>
        </div>

        <div class="sync-card-invoices p-1">
            <div class="d-inline-flex justify-content-between w-100">
                <x-app.dashboard.sync-card.info-label
                    label="Pedidos de venda sincronizados"
                    :value="$data['sales']['syncedQuantity']"
                />
            </div>

            <div class="d-inline-flex justify-content-between w-100">
                <x-app.dashboard.sync-card.timestamp-label :date="$data['sales']['lastUpdatedAt']" />
            </div>
        </div>

        <div class="d-flex justify-content-around my-1">
            <x-template.forms.post action="{{ route('dashboard.sync') }}">
                <button class="btn btn-primary" type="submit">
                    Sincronizar dados

                    <x-app.base.icons.icon icon="sync" />
                </button>
            </x-template.forms.post>
        </div>
    </x-template.card.card-body>
</x-template.card.card>
