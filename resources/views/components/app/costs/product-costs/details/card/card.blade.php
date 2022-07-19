<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <x-app.costs.product-costs.details.title.title :product="$product"/>

        <x-app.costs.product-costs.details.table.table
            :costs="$costs"
        />
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
