<x-layout>
    <div class="row">
        <x-template.alert-messages.alert-messages />
    </div>

    <div class="row my-4">
        <h3>Promoções</h3>
    </div>

    <div class="row">
        <div class="col">
            <x-app.promotions.list.card :promotions="$promotions" />
        </div>
    </div>
</x-layout>
