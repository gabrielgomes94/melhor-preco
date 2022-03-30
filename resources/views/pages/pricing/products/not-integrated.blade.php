<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar selected="" :marketplaces="$marketplaces"/>
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <x.bootstrap.card.basic.card>
            <h1>Produto não integrado.</h1>
        </x.bootstrap.card.basic.card>
    </div>
</x-layout>
