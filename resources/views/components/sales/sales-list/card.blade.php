<div class="row my-2">
    <div class="col-12">
        <x-template.card.card>
            <div class="mb-2">
                <x-sales.sales-list.table :saleOrders="$saleOrders" :total="$total" />
            </div>

            <div class="my-4">
                <x-utils.paginator-links :paginator="$paginator" />
            </div>
        </x-template.card.card>
    </div>
</div>
