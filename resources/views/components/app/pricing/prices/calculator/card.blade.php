<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <div class="row">
            <div class="col-4">
                <x-app.pricing.prices.calculator.forms.card
                    :calculatorForm="$calculatorForm"
                    :priceId="$priceId"
                />
            </div>
            <div class="col-8">
                <x-app.pricing.prices.calculator.table.card
                    :price="$price"
                    :priceId="$priceId"
                    :priceRaw="$priceRaw"
                    :productId="$productId"
                    :productInfo="$productInfo"
                />
            </div>
        </div>

    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>

