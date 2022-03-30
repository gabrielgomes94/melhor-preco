<x-layout>
    <div class="row full-height">
        <div class="col-1"></div>
        <div class="col-10">
            <x-bootstrap.alert-messages.alert-messages />

            <div class="my-4">
                <h3>Promoções</h3>
            </div>

            <div class="my-4">
                <x-app.promotions.update-form.card :promotion="$promotion"/>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</x-layout>
