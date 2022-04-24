<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <x-bootstrap.accordions.accordion-container
            accordionId="update-costs-accordion"
            accordionBodyId="update-costs-form-accordion"
            accordionHeaderId="update-costs-heading"
        >
            <x-slot name="accordionHeader">
                Atualizar custos
            </x-slot>

            <x-slot name="accordionBody">
                <x-app.pricing.prices.update-costs.form
                    :costs="$costsForm"
                    :productId="$productId"
                />
            </x-slot>
        </x-bootstrap.accordions.accordion-container>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
