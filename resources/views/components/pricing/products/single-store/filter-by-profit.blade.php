<x-forms.form.get
    :action="route('pricing.priceList.byStore', $store->slug())"
>
    <div class="">
        <x-forms.input.percentage
            attribute="minimumProfitFilter"
            label="Margem de Lucro mínima"
            value="{{ $minimumProfit }}"
        />

        <x-forms.input.percentage
            attribute="maximumProfitFilter"
            label="Margem de Lucro maxima"
            value="{{ $maximumProfit }}"
        />

        <div class="m-2">
            <x-forms.submit
                label="Filtrar"
                width="20"
            />
        </div>
    </div>
</x-forms.form.get>
