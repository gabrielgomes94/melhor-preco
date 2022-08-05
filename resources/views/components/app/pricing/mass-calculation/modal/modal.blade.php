<x-bootstrap.modals.modal
    id="massCalculation"
    title="Calcular em massa"
    actionLabel="Calcular"
    formId="mass-calculation-form"
>
    <x-app.pricing.mass-calculation.modal.content
        formId="mass-calculation-form"
        :filter="$filter"
        :marketplaceSlug="$marketplaceSlug"
        :massCalculation="$massCalculation ?? null"
    />
</x-bootstrap.modals.modal>
