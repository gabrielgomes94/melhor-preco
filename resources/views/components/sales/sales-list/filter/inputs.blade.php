<x-sales.date-picker
    label="Data de Início"
    id="beginDate"
    inputName="beginDate"
    formId="filter-sales-list">
</x-sales.date-picker>

<span class="mx-2"></span>

<x-sales.date-picker
    label="Data de Fim"
    id="endDate"
    inputName="endDate"
    formId="filter-sales-list">
</x-sales.date-picker>

<div class="input-group mb-3">
    <select class="form-select mb-3" aria-label=".form-select-lg example" name="sortOption">
        <option selected>Ordenar por</option>
        <option value="sku">SKU</option>
        <option value="product">Produto (ordem alfabética)</option>
        <option value="quantityDesc">Quantidade (ordem decrescente)</option>
        <option value="quantityAsc">Quantidade (ordem crescente)</option>
        <option value="averagePriceSale">Preço de venda médio</option>
        <option value="averageProfit">Lucro médio</option>
        <option value="averageProfitMargin">Margem média</option>
        <option value="totalRevenue">Faturamento total</option>
        <option value="totalProfit">Lucro total</option>
    </select>
</div>
