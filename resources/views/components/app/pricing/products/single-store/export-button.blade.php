<x-bootstrap.forms.form.post
    :action="route('pricing.products.export', $store->slug())"
>
    <x-bootstrap.forms.input.submit
        label="Exportar planilha"
        width="20"
    >
    </x-bootstrap.forms.input.submit>
</x-bootstrap.forms.form.post>
