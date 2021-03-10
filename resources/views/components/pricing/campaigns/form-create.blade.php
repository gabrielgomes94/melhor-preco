<div class="form-group">
    <form method="post" action="{{ route('pricing.campaigns.store') }}" enctype="multipart/form-data">
        @csrf

        <x-forms.input
            name="name"
            label="Nome"
            id="name"
            class="input-name"
            type="text"
            placeholder="exemplo: Carrinhos da Galzerano"
            value="{{ $campaign['name'] ?? '' }}">
        </x-forms.input>

        <x-forms.text-area
            name="skus"
            label="SKUs"
            id="skus"
            class="input-skus"
            value="{{ $campaign['value'] ?? '' }}">
        </x-forms.text-area>

        <x-forms.submit
            label="Calcular"
        >
        </x-forms.submit>
    </form>
</div>
