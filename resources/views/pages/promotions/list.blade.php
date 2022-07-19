<x-layout>
    <div class="row" style="{height: 800px}">
        <div class="col-1"></div>
        <div class="col-10">
            <x-bootstrap.alert-messages.alert-messages />

            <div class="my-4">
                <h3>Promoções</h3>
            </div>

            <x-app.promotions.list.card :promotions="$promotions" />
        </div>
        <div class="col-1"></div>
    </div>
</x-layout>
