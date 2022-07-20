<div class="row my-2">
    <div class="col-6">
        <x-bootstrap.forms.input.percentage
            attribute="minProfit"
            label="Margem de Lucro mínima"
            value="{{ $minimumProfit }}"
            id="minimum-profit-input"
        />
    </div>
    <div class="col-6">
        <x-bootstrap.forms.input.percentage
            attribute="maxProfit"
            label="Margem de Lucro maxima"
            value="{{ $maximumProfit }}"
            id="maximum-profit-input"
        />
    </div>
</div>

<div class="row my-2">
    <div class="col-12">
        <x-bootstrap.forms.input.text
            attribute="sku"
            label="SKU"
            visibleComponentId="sku"
            value="{{ $sku }}"
            id="sku-input"
        />
    </div>
</div>

<div class="mt-2 mb-1">
    <x-app.products.filters.category :filter="$filter" />
</div>

