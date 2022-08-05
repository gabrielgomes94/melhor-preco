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
            attribute="simplesNacionalTax"
            id="tax-rate-input"
            label="Alíquota do Simples Nacional (%)"
            value="{{ $taxes['simplesNacional'] ?? '' }}"
        />
    </div>

    <div class="my-2">
        <x-bootstrap.forms.input.text
            attribute="icmsTax"
            id="tax-rate-input"
            label="Alíquota do ICMS no seu estado (%)"
            value="{{ $taxes['icms'] ?? '' }}"
        />
    </div>

    <div class="d-inline-flex justify-content-end w-100 my-2">
        <x-bootstrap.buttons.submit label="Salvar"/>
    </div>
</x-bootstrap.forms.form.post>
