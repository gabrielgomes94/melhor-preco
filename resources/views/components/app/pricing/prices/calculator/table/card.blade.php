<x-bootstrap.card.basic.card class="h-100">
    <x-bootstrap.card.basic.card-body>
        <div class="d-flex flex-column justify-content-between">
            <x-app.pricing.prices.calculator.table.card-header :productInfo="$productInfo"/>

            <x-app.pricing.prices.calculator.table.table
                :productId="$productId"
                :price="$price"
                :priceRaw="$priceRaw"
            />
        </div>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
