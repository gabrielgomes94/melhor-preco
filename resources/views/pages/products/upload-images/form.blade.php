<x-layout>
    <x-app.products.navigation :activeNavUploadImages="true" />

    <div class="row">
        <div class="col-12 mb-4">
            <x-bootstrap.alert-messages.alert-messages />

            <x-app.products.upload-images.card />
        </div>
    </div>
</x-layout>
