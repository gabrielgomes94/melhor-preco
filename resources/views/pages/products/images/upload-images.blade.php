<x-layout>
    <x-app.products.navigation :activeNavUploadImages="true" />

    <div class="row">
        <div class="col-12 mb-4">
            <x-bootstrap.alert-messages.alert-messages />

            <x-bootstrap.card.basic.card>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Upload de Imagens
                </h2>
                <x-app.products.images.upload-form />
            </x-bootstrap.card.basic.card>
        </div>
    </div>
</x-layout>
