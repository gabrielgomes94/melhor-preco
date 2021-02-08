<div>
    <h3>
        Preço Sugerido
    </h3>

    <div>
        @isset($salePrices['salePrices'])
            <h6><strong>Preço de venda:</strong> {{ $salePrices['salePrices']['normal']['sellingPrice'] }}</h6>
            <h6><strong>Lucro:</strong> {{ $salePrices['salePrices']['normal']['profit'] }}</h6>
        @endisset
    </div>
</div>
