<div>
    <h3>
        Preço Sugerido
    </h3>

    <div>
        @isset($salePrices['salePrices'])
            <h5>Preço sugerido</h5>
            <h6><strong>Preço de venda:</strong> {{ $salePrices['salePrices']['normal']['sellingPrice'] }}</h6>
            <h6 class="text-danger"><strong>Preço de custo:</strong> {{ $salePrices['salePrices']['normal']['costPrice'] }}</h6>
            <h6 class="text-danger"><strong>Comissão:</strong> {{ $salePrices['salePrices']['normal']['commission'] }}</h6>
            <h6 class="text-success"><strong>Lucro:</strong> {{ $salePrices['salePrices']['normal']['profit'] }}</h6>
            <br>

            <h5>Preço sugerido com 5% de desconto à vista</h5>
            <h6><strong>Preço de venda:</strong> {{ $salePrices['salePrices']['5PercentDiscount']['sellingPrice'] }}</h6>
            <h6 class="text-danger"><strong>Preço de custo:</strong> {{ $salePrices['salePrices']['5PercentDiscount']['costPrice'] }}</h6>
            <h6 class="text-danger"><strong>Comissão:</strong> {{ $salePrices['salePrices']['5PercentDiscount']['commission'] }}</h6>
            <h6 class="text-success"><strong>Lucro:</strong> {{ $salePrices['salePrices']['5PercentDiscount']['profit'] }}</h6>
            <br>

            <h5>Preço mínimo. Abaixo disso temos prejuízo: </h5>
            <h6><strong>Preço de venda:</strong> {{ $salePrices['salePrices']['minimumPossibleValue']['sellingPrice'] }}</h6>
            <h6 class="text-danger"><strong>Preço de custo:</strong> {{ $salePrices['salePrices']['minimumPossibleValue']['costPrice'] }}</h6>
            <h6 class="text-danger"><strong>Comissão:</strong> {{ $salePrices['salePrices']['minimumPossibleValue']['commission'] }}</h6>
            <h6 class="text-success"><strong>Lucro:</strong> {{ $salePrices['salePrices']['minimumPossibleValue']['profit'] }}</h6>
        @endisset
    </div>
</div>
