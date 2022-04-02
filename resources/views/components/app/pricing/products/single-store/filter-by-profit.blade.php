<div class="row">
    <div class="col-6">
        <x-bootstrap.forms.input.percentage
            attribute="minProfit"
            label="Margem de Lucro mínima"
            value="{{ $minimumProfit }}"
        />
    </div>
    <div class="col-6">
        <x-bootstrap.forms.input.percentage
            attribute="maxProfit"
            label="Margem de Lucro maxima"
            value="{{ $maximumProfit }}"
        />
    </div>

    <div class="col-12">
        <x-bootstrap.forms.input.text
            attribute="sku"
            label="SKU"
            visibleComponentId="sku"
            value="{{ $sku }}"
        />
    </div>
</div>

