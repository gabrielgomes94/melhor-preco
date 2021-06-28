<x-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Precificação') }}
            </h2>
        </x-slot>

        <h3>{{ $pricing->name }}</h3>

        <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>
        <div class="row">
            <div class="col">
                <x-pricing.products.list-table :pricing="$pricing" />
            </div>
        </div>

        <x-forms.form.post
            :action="route('pricing.export', $pricing->id)"
        >
            <x-forms.submit
                label="Exportar"
                width="20"
            >
            </x-forms.submit>
        </x-forms.form.post>
    </div>
</x-layout>
