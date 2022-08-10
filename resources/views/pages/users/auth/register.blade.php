<x-guest-layout>
    <x-app.guest.background>
        <div class="col-12 d-flex align-items-center justify-content-center">
            <x-app.auth.register.card.card>
                <x-bootstrap.alert-messages.alert-messages />

                <x-app.auth.register.card.title />

                <x-app.auth.register.card.form />

                <div class="mt-3 mb-4 text-center">
                    <span class="fw-normal">
                        ou faça
                        <x-bootstrap.links.link route="{{ route('login') }}">
                            login
                        </x-bootstrap.links.link>
                    </span>
                </div>
            </x-app.auth.register.card.card>
        </div>
    </x-app.guest.background>
</x-guest-layout>
