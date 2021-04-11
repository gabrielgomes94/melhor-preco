<x-layout>
    <div class="container">
        <x-slot name="header">
            <div class="d-inline-flex justify-content-between w-100">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Cadastrar precificação') }}
                    </h2>
                </div>


                <x-utils.navigation-button
                    :route="route('pricing.list')"
                    label="Voltar"
                />
            </div>
        </x-slot>

        <div class="row mt-2">
            <div class="col">
                <x-pricing.campaigns.form-create/>
            </div>
        </div>
    </div>
</x-layout>
