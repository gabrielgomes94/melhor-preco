<x-layout>
    <x-slot name="navbar">
        <x-app.sales.navbar />
    </x-slot>

    <div class="container">
        <div class="row">
            <x-bootstrap.alert-messages.alert-messages />
        </div>
    </div>

    <div class="row">
        <div class="d-inline-flex justify-content-end m-1">
            <div class="mx-1">
                <x-app.sales.sales-list.sync.button />
            </div>
        </div>
    </div>

    <div class="mb-4">
        <x-app.sales.sales-list.card>
            <div class="p-4">
                <div class="d-inline-flex justify-content-between m-1 w-100">
                    <div class="mx-1 py-2">
                        <h3>Lista de Vendas</h3>
                    </div>

                    <div class="mb-2">
                        <x-app.sales.sales-list.filter.form :route="route('sales.list')"/>
                    </div>
                </div>

                <x-app.sales.sales-list.table.table
                    :saleOrders="$saleOrders"
                    :total="$total"
                    :paginator="$paginator"
                />
            </div>
        </x-app.sales.sales-list.card>
    </div>
</x-layout>
