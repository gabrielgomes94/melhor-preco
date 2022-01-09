<x-template.card.card>
    <div class="d-inline-flex justify-content-between align-items-center m-1">
        <h2>Nota fiscal</h2>
    </div>

    <x-app.costs.purchase-invoice.invoice-info :data="$data" />

    <div class="m-1 w-100">
        <x-template.forms.put :action="route('costs.linkProduct')">
            <x-app.costs.purchase-invoice.items :items="$data['items']" />

            <div class="d-inline-flex justify-content-end w-100">
                <x-template.buttons.submit label="Voltar"/>

                <div class="mx-1"></div>

                <x-template.buttons.submit label="Vincular SKUs"/>
            </div>
        </x-template.forms.put>
    </div>
</x-template.card.card>
