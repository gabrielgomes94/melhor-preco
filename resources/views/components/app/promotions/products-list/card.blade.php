<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <x-bootstrap.forms.form.post :action="route('promotions.export', $promotion['uuid'])">
            <x-bootstrap.forms.input.submit
                label="Gerar planilha de promoção"
            />
        </x-bootstrap.forms.form.post>
    </x-slot>

    <x-slot name="body">
        <x-app.promotions.products-list.table :products="$promotion['products']" />
    </x-slot>
</x-bootstrap.card.basic-card>
