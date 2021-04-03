<x-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Precificação') }}
            </h2>
        </x-slot>

        <div class="row">
            <div class="col">
                <x-utils.navigation-button
                    :route="route('pricing.create')"
                    label="Novo"
                />

                <x-utils.navigation-button
                    customStyleClass="btn-secondary"
                    :route="route('products.upload')"
                    label="Atualizar dados de Produto"
                />
                <!-- utils/pageTitle -->


                <x-pricing.campaigns-table :campaigns="$campaigns"/>
            </div>
        </div>
    </div>
</x-layout>
