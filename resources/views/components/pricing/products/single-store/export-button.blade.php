<x-forms.form.post
    :action="route('pricing.products.export', $store->slug())"
>
    <x-forms.submit
        label="Exportar planilha"
        width="20"
    >
    </x-forms.submit>
</x-forms.form.post>
