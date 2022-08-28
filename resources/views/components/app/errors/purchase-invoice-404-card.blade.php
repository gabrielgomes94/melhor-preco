<x-bootstrap.card.basic.card class="p-1 w-100">
    <x-bootstrap.card.basic.card-body>
        <div class="d-inline-flex justify-content-between">
            <div class="my-2">
                <div class="py-1">
                    A nota fiscal não está cadastrada no sistema.
                </div>

                <div class="py-1">
                    Tente sincronizá-la na tela de
                    <a href="{{ route('users.settings.integrations') }}" class="link">
                        integrações.
                    </a>
                </div>
            </div>

            <div class="">
                <svg clip-rule="evenodd"
                     fill-rule="evenodd"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg"
                     width="128"
                >
                    <path d="m2.095 19.886 9.248-16.5c.133-.237.384-.384.657-.384.272 0 .524.147.656.384l9.248 16.5c.064.115.096.241.096.367 0 .385-.309.749-.752.749h-18.496c-.44 0-.752-.36-.752-.749 0-.126.031-.252.095-.367zm1.935-.384h15.939l-7.97-14.219zm7.972-6.497c-.414 0-.75.336-.75.75v3.5c0 .414.336.75.75.75s.75-.336.75-.75v-3.5c0-.414-.336-.75-.75-.75zm-.002-3c.552 0 1 .448 1 1s-.448 1-1 1-1-.448-1-1 .448-1 1-1z"
                    />
                </svg>
            </div>
        </div>
    </x-bootstrap.card.basic.card-body>

    <div class="my-4"></div>
</x-bootstrap.card.basic.card>
