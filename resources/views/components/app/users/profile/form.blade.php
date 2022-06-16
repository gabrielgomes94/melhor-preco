<x-bootstrap.forms.form.post
    :action="route('users.settings.profile')"
>
    @csrf

    <div class="my-2">
        <x-bootstrap.forms.input.text
            attribute="name"
            id="profile-name-input"
            label="Nome"
            value="{{ $name ?? '' }}"
        />
    </div>

    <div class="my-2">
        <label for="profile-fiscal-id-input">CNPJ ou CPF</label>

        <input name="fiscal_id"
               type="text"
               class="form-control"
               id="profile-fiscal-id-input"
               value="{{ old('fiscal_id') ?? $fiscalId ?? '' }}"
               data-registration-fiscal-id
               required
        >
    </div>

    <div class="my-2">
        <label for="profile-phone-input">Telefone</label>

        <input name="phone"
               type="text"
               class="form-control"
               id="profile-phone-input"
               value="{{ old('phone') ?? $phone ?? '' }}"
               data-registration-phone
               required
        >
    </div>

    <div class="d-inline-flex justify-content-end w-100 my-2">
        <x-bootstrap.buttons.submit label="Salvar"/>
    </div>
</x-bootstrap.forms.form.post>
