<x-template.card.card>
    <x-app.costs.product-costs.details.card-header :product="$data['product']" />

    <x-app.costs.product-costs.details.table.table :data="$data['items']" />
</x-template.card.card>
