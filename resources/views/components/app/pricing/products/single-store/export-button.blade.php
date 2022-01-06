<x-template.forms.post
    :action="route('pricing.products.export', $store->slug())"
>
    <x-template.input.submit
        label="Exportar planilha"
        width="20"
    >
    </x-template.input.submit>
</x-template.forms.post>
