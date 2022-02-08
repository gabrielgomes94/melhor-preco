<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar selected="" :marketplaces="$marketplaces"/>
    </x-slot>

    <div class="row">
        <x-template.alert-messages.alert-messages />
    </div>

    <div class="row">
        <x.template.card.card>
            <h1>Produto não integrado.</h1>
        </x.template.card.card>
    </div>
</x-layout>
