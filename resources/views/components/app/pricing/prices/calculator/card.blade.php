<x-template.card.card>
    <h4 class="text-center">Calcular</h4>

    <x-app.pricing.prices.calculator.forms.calculator :price="$price" :productId="$product->getSku()" />
</x-template.card.card>

