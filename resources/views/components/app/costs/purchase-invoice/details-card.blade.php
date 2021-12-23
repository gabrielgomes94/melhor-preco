<x-template.card.card>
    <x-app.costs.purchase-invoice.invoice-info :data="$data" />

    <div class="m-1 w-100">
        <x-app.costs.purchase-invoice.items :items="$data['items']" />

        <div class="d-inline-flex justify-content-end w-100">
            <x-template.buttons.submit label="Voltar"/>

            <div class="mx-1"></div>

            <x-template.buttons.submit label="Vincular SKUs"/>
        </div>

    </div>
</x-template.card.card>
