<x-bootstrap.table.bordered-table >
    <thead>

    </thead>

    <tbody>
    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-value"
        label="Preço"
        :value="$price['suggestedPrice']"
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-purchasePrice"
        label="Preço de Compra"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-commission"
        label="Comissão"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-freight"
        label="Frete"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-taxSimplesNacional"
        label="Simples Nacional"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-differenceICMS"
        label="Diferença de ICMS"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-profit"
        label="Lucro"
        :value="$price['profit']"
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['priceId'] }}-margin"
        label="Margem"
        :value="$price['margin']"
    />
    </tbody>
</x-bootstrap.table.bordered-table>

