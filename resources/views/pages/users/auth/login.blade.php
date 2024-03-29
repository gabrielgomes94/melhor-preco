<x-guest-layout>
    <main>
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center form-bg-image" data-background-lg="{{ asset('images/illustrations/signin.svg') }}">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">

                            @if (session('status'))
                                <div class="my-2 alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Melhor Preço</h1>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="mt-4">
                                @csrf

                                <div class="form-group mb-4">
                                    <label for="email">Email</label>

                                    <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z">
                                                    </path>
                                                </svg>
                                            </span>

                                        <input type="email"
                                               name="email"
                                               class="form-control"
                                               id="email" value="{{ old('email') }}" autofocus required
                                        >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group mb-4">
                                        <label for="password">Senha</label>

                                        <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd">
                                                        </path>
                                                    </svg>
                                                </span>

                                            <input type="password"
                                                   name="password"
                                                   class="form-control"
                                                   id="password" required
                                            >
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-top mb-4">
                                        <div class="form-check">
                                            <label for="remember_me" class="flex items-center">
                                                <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                                                <label class="form-check-label mb-0" for="remember">
                                                    Lembrar senha
                                                </label>
                                            </label>
                                        </div>

                                        <div>
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="small text-right">Esqueceu sua senha?</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gray-800">Login</button>
                                </div>
                            </form>

                            <div class="mt-3 mb-4 text-center">
                                <span class="fw-normal">
                                    Não possui conta ainda?
                                    <x-bootstrap.links.link route="{{ route('register') }}">
                                        Cadastre-se
                                    </x-bootstrap.links.link>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-guest-layout>
