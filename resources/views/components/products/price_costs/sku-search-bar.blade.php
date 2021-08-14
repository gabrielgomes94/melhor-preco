<x-forms.form.get
    :action="route('products.costs.edit')"
>
    <div class="">
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
