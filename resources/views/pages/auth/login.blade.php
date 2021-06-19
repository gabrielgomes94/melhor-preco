<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <h1>Barrigudinha Backoffice</h1>

                    <div class="login-card">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <x-jet-label for="email" class="col-form-label" value="{{ __('Email') }}" />
                                </div>

                                <div class="col-sm-10">
                                    <x-jet-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
                                </div>
                            </div>

                            <div class="mt-4 form-group row">
                                <div class="col-sm-2">
                                    <x-jet-label for="password" class="col-form-label" value="{{ __('Senha') }}" />
                                </div>

                                <div class="col-sm-10">
                                    <x-jet-input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="current-password" />
                                </div>
                            </div>

                            <div class="block mt-4">
                                <label for="remember_me" class="flex items-center">
                                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar senha') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu sua senha?') }}
                                    </a>
                                @endif

                                <x-jet-button class="ml-4 btn btn-primary">
                                    {{ __('Login') }}
                                </x-jet-button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>

    </x-jet-authentication-card>
</x-guest-layout>
