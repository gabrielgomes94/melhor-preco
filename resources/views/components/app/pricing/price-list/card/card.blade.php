<x-bootstrap.card.basic.card class="p-1">
    <x-bootstrap.card.basic.card-body>
        <x-app.pricing.price-list.products.store-list.table
            :products="$products"
            :store="$store"
        />
    </x-bootstrap.card.basic.card-body>

    <div class="my-4">
        <x-bootstrap.paginator.paginator-links :paginator="$paginator" />
    </div>
</x-bootstrap.card.basic.card>
