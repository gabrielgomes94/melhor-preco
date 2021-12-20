<body class="antialiased">
    <x-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Emissão de Etiquetas de Estoque') }}
            </h2>
        </x-slot>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="error-container">
                        <div id="error-box" class="">
                            <p id="error-box-message" class="text-danger"></p>
                        </div>

                        <x-template.alert-messages.alert-messages />
                    </div>

                    <x-template.card.card>
                        <x-app.products.stock_tags.forms.list-tags />

                        <x-app.products.stock_tags.forms.generate-tags />
                    </x-template.card.card>
                </div>
            </div>
        </div>
    </x-layout>
</body>
