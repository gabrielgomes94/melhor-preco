<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <div class="row">
            <div class="col-4">
                <h4 class="text-center">Calcular</h4>

                <x-app.pricing.prices.calculator.forms.calculator
                    :calculatorForm="$calculatorForm"
                />
            </div>
            <div class="col-8">
                <x-app.pricing.prices.price.card
                    :price="$price"
                    :priceRaw="$priceRaw"
                    :productId="$productId"
                    :productInfo="$productInfo"
                />
            </div>
        </div>

    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>

