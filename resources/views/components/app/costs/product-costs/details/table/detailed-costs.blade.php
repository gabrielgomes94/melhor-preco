<table>
    <tbody>
        <x-app.costs.product-costs.details.table.cost-row
            label="Preço de Compra"
            :value="$itemCosts['purchasePrice'] ?? ''"
        />

        <x-app.costs.product-costs.details.table.cost-row
            label="Impostos"
            :value="$itemCosts['taxes'] ?? ''"
        />

        <x-app.costs.product-costs.details.table.cost-row
            label="Frete"
            :value="$itemCosts['freight'] ?? ''"
        />

        <x-app.costs.product-costs.details.table.cost-row
            label="Seguro"
            :value="$itemCosts['insurance'] ?? ''"
        />

        <x-app.costs.product-costs.details.table.cost-row
            label="Alíquota ICMS"
            :value="$itemCosts['icms'] ?? ''"
        />
    </tbody>
</table>
