<x-guest-layout>
    <x-app.guest.background>
        <div class="col-12 d-flex align-items-center justify-content-center">
            <x-app.users.auth.register.card.card>
                <x-bootstrap.alert-messages.alert-messages />

                <div class="text-center text-md-center mb-4 mt-md-0">
                    <h1 class="mb-0 h3">Reset de senha</h1>
                </div>


                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input name="token"
                           type="hidden"
                           id="reset-password-token-input"
                           value="{{ request()->route('token') }}"
                    >


                    <div class="form-group mb-4">
                        <x-app.users.auth.register.card.inputs.email />
                    </div>

                    <div class="form-group mb-4">
                        <x-app.users.auth.register.card.inputs.password />
                    </div>

                    <div class="form-group mb-4">
                        <x-app.users.auth.register.card.inputs.password-confirmation />
                    </div>


                    <div class="d-grid">
                        <button type="submit" class="btn btn-gray-800">
                            Resetar senha
                        </button>
                    </div>
                </form>

                <div class="mt-3 mb-1 text-center">
                    <span class="fw-normal">
                        Não possui conta ainda?
                        <x-bootstrap.links.link route="{{ route('register') }}">
                            Cadastre-se
                        </x-bootstrap.links.link>
                    </span>
                </div>

                <div class="mt-1 mb-4 text-center">
                    <span class="fw-normal">
                        Ou faça
                        <x-bootstrap.links.link route="{{ route('login') }}">
                            login
                        </x-bootstrap.links.link>
                    </span>
                </div>

            </x-app.users.auth.register.card.card>
        </div>
    </x-app.guest.background>
</x-guest-layout>
