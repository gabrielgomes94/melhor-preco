<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <h4 class="text-center">Calcular</h4>

        <x-app.pricing.prices.calculator.forms.calculator
{{--            :price="$price"--}}
{{--            :productId="$product->getSku()"--}}
{{--            :isFreeFreightDisabled="$isFreeFreightDisabled"--}}
            :calculatorForm="$calculatorForm"

            :priceId="$calculatorForm['priceId']"
            :productId="$calculatorForm['productId']"
            :marketplaceSlug="$calculatorForm['marketplaceSlug']"
            :marketplaceName="$calculatorForm['marketplaceSlug']"
            :commission="$calculatorForm['commission']"
            :discount="$calculatorForm['discount']"
            :desiredPrice="$calculatorForm['desiredPrice']"
            :isFreeFreightDisabled="$calculatorForm['isFreeFreightDisabled']"
        />
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>

