<x-forms.form.get
    :action="route('pricing.priceList.byStore', $store->slug())"
>
    <div class="">
        <x-forms.input.percentage
            attribute="minProfit"
            label="Margem de Lucro mínima"
            value="{{ $minimumProfit }}"
        />

        <x-forms.input.percentage
            attribute="maxProfit"
            label="Margem de Lucro maxima"
            value="{{ $maximumProfit }}"
        />

        <x-forms.input.text
            attribute="sku"
            label="SKU"
            visibleComponentId="sku"
            value="{{ $sku }}"
        />

        <div class="m-2">
            <x-forms.submit
                label="Filtrar"
                width="20"
            />
        </div>
    </div>
</x-forms.form.get>
