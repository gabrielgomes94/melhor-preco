<x-bootstrap.table.bordered-table >
    <thead>

    </thead>

    <tbody>
    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-value"
        label="Preço"
        :value="$price['mainPrice']['value']"
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-purchasePrice"
        label="Preço de Compra"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-commission"
        label="Comissão"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-freight"
        label="Frete"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-taxSimplesNacional"
        label="Simples Nacional"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-differenceICMS"
        label="Diferença de ICMS"
{{--        :value=""--}}
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-profit"
        label="Lucro"
        :value="$price['mainPrice']['profit']"
    />

    <x-app.pricing.prices.calculated-price.table-cell
        id="update-price-{{ $price['id'] }}-margin"
        label="Margem"
        :value="$price['mainPrice']['margin']"
    />
    </tbody>
</x-bootstrap.table.bordered-table>

