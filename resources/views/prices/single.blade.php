<x-layout>
    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-8">

                <h1>Calculadora de preços</h1>
                <x-prices.single-form></x-prices.single-form>
            </div>
            <div class="col-sm-4">
                <x-prices.sale-prices :salePrices="$salePrices ?? []"></x-prices.sale-prices>
            </div>
        </div>
    </div>
</x-layout>
