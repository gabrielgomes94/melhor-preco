<x-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Criar Campanha de Preço') }}
            </h2>
        </x-slot>


        <div class="row">
            <div class="col">
                <x-pricing.campaigns.form-create/>
            </div>
        </div>
    </div>
</x-layout>
