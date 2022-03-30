<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <h4 class="text-center">Calcular</h4>

        <x-app.pricing.prices.calculator.forms.calculator
            :price="$price"
            :productId="$product->getSku()"
            :isFreeFreightDisabled="$isFreeFreightDisabled"
        />
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>

