<x-bootstrap.table.bordered-table >
    <tbody>
        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-value"
            label="Preço"
            :value="$price['suggestedPrice']"
            class="text-success"
            bold="true"
        />

        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-purchasePrice"
            label="Preço de Compra"
            :value="$price['purchasePrice']"
            class="text-danger"
        />

        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-commission"
            label="Comissão"
            :value="$price['commission']"
            class="text-danger"
        />

        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-freight"
            label="Frete"
            :value="$price['freight']"
            class="text-danger"
        />

        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-taxSimplesNacional"
            label="Simples Nacional"
            :value="$price['taxSimplesNacional']"
            class="text-danger"
        />

        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-differenceICMS"
            label="Diferença de ICMS"
            :value="$price['differenceICMS']"
            class="text-danger"
        />

        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-profit"
            label="Lucro"
            :value="$price['profit']"
            class="{{ ($priceRaw['profit'] > 0) ? 'text-success' : 'text-danger' }}"
            bold="true"
        />

        <x-app.pricing.prices.calculator.table.table-cell
            id="update-price-{{ $priceId }}-margin"
            label="Margem"
            :value="$price['margin']"
            class="{{ ($priceRaw['margin'] > 0) ? 'text-success' : 'text-danger' }}"
            bold="true"
        />
    </tbody>
</x-bootstrap.table.bordered-table>

