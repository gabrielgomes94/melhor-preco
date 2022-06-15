<x-bootstrap.forms.form.post
    :action="route('users.settings.updateErp')"
>
    <div class="my-2">
        <x-bootstrap.forms.input.read-only
            name="erp"
            id="integration-erp-input"
            label="ERP"
            value="Bling"
        />
    </div>

    <div class="my-2">
        <x-bootstrap.forms.input.text
            name="erpToken"
            id="erp-token-input"
            label="Token do ERP"
            value="{{ $erpToken ?? '' }}"
        />
    </div>

    <div class="d-inline-flex justify-content-end w-100 my-2">
        <x-bootstrap.buttons.submit label="Salvar"/>
    </div>
</x-bootstrap.forms.form.post>
