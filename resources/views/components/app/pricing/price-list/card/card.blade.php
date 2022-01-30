<x-template.card.card class="p-1">
    <x-template.card.card-body>
        <x-app.pricing.price-list.products.store-list.table
            :products="$products"
            :store="$store"
        />
    </x-template.card.card-body>

    <div class="my-4">
        <x-template.paginator.paginator-links :paginator="$paginator" />
    </div>
</x-template.card.card>
