<x-forms.form.get
    :action="route('products.costs.edit')"
>
    <div class="d-flex justify-content-around">
        <x-forms.input.text
            attribute="sku"
            label="SKU"
            visibleComponentId="sku"
            value="{{ $sku }}"
        />

        <div class="d-flex align-items-end px-2">
            <x-template.buttons.submit label="Filtrar" />
        </div>
    </div>
</x-forms.form.get>
