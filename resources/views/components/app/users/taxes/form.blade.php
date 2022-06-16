<x-bootstrap.forms.form.post
    :action="route('users.settings.taxes')"
>
    @csrf

    <div class="my-2">
        <x-bootstrap.forms.input.read-only
            name="tax_regime"
            id="tax-regime-input"
            label="Regime Tributário"
            value="Simples Nacional"
        />
    </div>

    <div class="my-2">
        <x-bootstrap.forms.input.text
            attribute="tax_rate"
            id="tax-rate-input"
            label="Alíquota"
            value="{{ $taxRate ?? '' }}"
        />
    </div>

    <div class="d-inline-flex justify-content-end w-100 my-2">
        <x-bootstrap.buttons.submit label="Salvar"/>
    </div>
</x-bootstrap.forms.form.post>
