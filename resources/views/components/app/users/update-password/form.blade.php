<x-bootstrap.forms.form.post
    :action="route('users.settings.updatePassword')"
>
    @csrf

    <div class="my-2">
        <label for="profile-fiscal-id-input">Senha atual</label>

        <input name="current_password"
               type="password"
               class="form-control"
               id="current-password-input"
               required
        >
    </div>

    <div class="my-2">
        <label for="profile-fiscal-id-input">Nova senha</label>

        <input name="password"
               type="password"
               class="form-control"
               id="password-input"
               required
        >
    </div>

    <div class="my-2">
        <label for="profile-fiscal-id-input">Confirmação da nova senha</label>

        <input name="password_confirmation"
               type="password"
               class="form-control"
               id="password-confirmation-input"
               required
        >
    </div>

    <div class="d-inline-flex justify-content-end w-100 my-2">
        <x-bootstrap.buttons.submit label="Salvar"/>
    </div>
</x-bootstrap.forms.form.post>
