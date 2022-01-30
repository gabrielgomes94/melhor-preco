<x-template.forms.post action="{{ route('marketplaces.doSetUniqueCommission', $marketplaceSlug) }}">
    <div class="mt-1">
        <x-bootstrap.forms.input.text
            attribute="commission"
            id="commission-input"
            label="Comissão (%)"
            value=""
        />
    </div>

    <div class="d-flex justify-content-center mt-3">
        <x-bootstrap.forms.input.submit label="Salvar" />
    </div>
</x-template.forms.post>
