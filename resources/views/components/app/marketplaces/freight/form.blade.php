<x-bootstrap.forms.form.post
    action="{{ route('marketplaces.doSetFreight', $marketplaceSlug) }}"
>
    <div class="mt-1">
        <x-bootstrap.forms.input.text
            attribute="baseValue"
            id="base-value-input"
            label="Frete padrão (R$)"
            value="{{ $freight['defaultValue'] }}"
        />
    </div>

    <div class="mt-1">
        <x-bootstrap.forms.input.text
            attribute="minimumFreightTableValue"
            id="minimum-freight-table-value-input"
            label="Valor mínimo para tabela de frete"
            value="{{ $freight['minimumFreightTableValue'] }}"
        />
    </div>

    <div class="mt-1">
        <label for="freight-table-input" class="form-label">
            Tabela de frete
        </label>
        <input name="freightTable"
               type="file"
               class="input-file form-control"
               id="freight-table-input"
        >

        <x-bootstrap.links.link :route="route('marketplaces.downloads.template')">
            Download do template da planilha de frete
        </x-bootstrap.links.link>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <x-bootstrap.forms.input.submit label="Salvar" />
    </div>
</x-bootstrap.forms.form.post>
