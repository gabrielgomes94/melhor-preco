<x-bootstrap.modals.modal
    id="massCalculation"
    title="Calcular em massa"
    actionLabel="Calcular"
    formId="mass-calculation-form"
>
    <x-app.pricing.price-list.mass-calculation.modal.content
        :store="$store"
        formId="mass-calculation-form"
        :filter="$filter"
        :massCalculation="$massCalculation"
    />
</x-bootstrap.modals.modal>
