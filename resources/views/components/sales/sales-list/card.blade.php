<div class="row my-2">
    <div class="col-12">
        <x-template.card.card>
            <div class="mb-2">
                <x-sales.sales-list.table.table :saleOrders="$saleOrders" :total="$total" :paginator="$paginator"/>
            </div>
        </x-template.card.card>
    </div>
</div>
