<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload de Imagens') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-12 mb-4">
            <x-utils.alert-messages />

            <x-template.card.card>
                <x-app.products.images.upload-form />
            </x-template.card.card>
        </div>
    </div>
</x-layout>
