<div class="form-group">
    <x-utils.error-box></x-utils.error-box>

    <div class="container">
        <form method="post" action="{{ route('pricing.campaigns.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col">
                    <x-forms.input
                        name="name"
                        label="Nome"
                        id="name"
                        class="input-name"
                        type="text"
                        placeholder="exemplo: Carrinhos da Galzerano"
                        value="{{ $campaign['name'] ?? '' }}">
                    </x-forms.input>

                    <x-pricing.forms.checkbox.store
                        name="stores"
                        id="stores"
                    >
                    </x-pricing.forms.checkbox.store>
                </div>

                <div class="col">
                    <x-forms.text-area
                        name="skus"
                        label="SKUs"
                        id="skus"
                        class="input-skus"
                        value="{{ $campaign['value'] ?? '' }}">
                    </x-forms.text-area>
                </div>

                <x-forms.submit
                    label="Calcular"
                >
                </x-forms.submit>
            </div>
        </form>
    </div>
</div>
