<x-layout>
    <x-slot name="header">
        Vendas
    </x-slot>

    <div class="container">
        <div class="row">
            <x-utils.alert-messages />
        </div>
    </div>

    <div class="row">
        <div class="d-inline-flex justify-content-end m-1">
            <div class="mx-1">
                <x-sales.sales-list.sync.button />
            </div>
        </div>
    </div>

    <x-sales.sales-list.card :paginator="$paginator" :saleOrders="$saleOrders" :total="$total" />
</x-layout>
