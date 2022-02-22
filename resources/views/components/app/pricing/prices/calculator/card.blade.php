<x-template.card.card>
    <x-template.card.card-body>
        <h4 class="text-center">Calcular</h4>

        <x-app.pricing.prices.calculator.forms.calculator
            :price="$price"
            :productId="$product->getSku()"
            :isFreeFreightDisabled="$isFreeFreightDisabled"
        />
    </x-template.card.card-body>
</x-template.card.card>

