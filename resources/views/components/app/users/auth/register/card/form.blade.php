<form action="{{ route('register') }}" method="POST" class="mt-4">
    {{ csrf_field() }}

    <div class="form-group mb-4">
        <x-app.users.auth.register.card.inputs.email />
    </div>

    <div class="form-group mb-4">
        <x-app.users.auth.register.card.inputs.fiscal-id />
    </div>

    <div class="form-group mb-4">
        <x-app.users.auth.register.card.inputs.name />
    </div>

    <div class="form-group mb-4">
        <x-app.users.auth.register.card.inputs.phone />
    </div>

    <div class="form-group mb-4">
        <x-app.users.auth.register.card.inputs.password />
    </div>

    <div class="form-group mb-4">
        <x-app.users.auth.register.card.inputs.password-confirmation />
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-gray-800">
            Cadastre-se
        </button>
    </div>
</form>
