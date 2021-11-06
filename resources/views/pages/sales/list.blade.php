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
        <div class="d-flex justify-content-end">
            <div class="m-1">
                <x-template.forms.get :action="route('sales.export')">
                    <div class="py-2">
                        <x-template.buttons.submit label="Exportar planilha" />
                    </div>
                </x-template.forms.get>
            </div>

            <div class="m-1">
                <x-sales.sales-list.filter></x-sales.sales-list.filter>
            </div>
        </div>
    </div>

    <x-sales.sales-list.card :paginator="$paginator" :saleOrders="$saleOrders" :total="$total" />
</x-layout>
