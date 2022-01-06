<x-template.forms.get
    :action="route('pricing.priceList.byStore', $store->slug())"
    :formId="$formId"
>
    <div class="row">
        <div class="col-6">
            <x-template.input.percentage
                attribute="minProfit"
                label="Margem de Lucro mínima"
                value="{{ $minimumProfit }}"
            />
        </div>
        <div class="col-6">
            <x-template.input.percentage
                attribute="maxProfit"
                label="Margem de Lucro maxima"
                value="{{ $maximumProfit }}"
            />
        </div>

        <div class="col-12">
            <x-template.input.text
                attribute="sku"
                label="SKU"
                visibleComponentId="sku"
                value="{{ $sku }}"
            />
        </div>
    </div>
</x-template.forms.get>
