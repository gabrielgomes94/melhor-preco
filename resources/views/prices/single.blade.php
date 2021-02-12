<x-layout>
    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-6">
                <h1>Calculadora de preços</h1>
                <x-prices.single-form :purchasePrice="$purchasePrice ?? null" :priceParams="$priceParams ?? null"></x-prices.single-form>
            </div>
            <div class="col-sm-6">
                <x-prices.sale-prices :salePrices="$salePrices ?? []"></x-prices.sale-prices>
            </div>
        </div>
    </div>
</x-layout>
