<div class="row my-1">
    <div class="col-2">
        <x-bootstrap.forms.input.read-only
            id="attributeSeries"
            label="Série"
            attribute="series"
            value="{{ $data['series'] }}"
        />
    </div>

    <div class="col-3">
        <x-bootstrap.forms.input.read-only
            id="attributeNumber"
            label="Número"
            attribute="number"
            value="{{ $data['number'] }}"
        />
    </div>

    <div class="col-3">
        <x-bootstrap.forms.input.read-only
            id="attributeIssuedAt"
            label="Data de Emissão"
            attribute="issuedAt"
            value="{{ $data['issuedAt'] }}"
        />
    </div>

    <div class="col-4">
        <x-bootstrap.forms.input.read-only
            id="attributeSituation"
            label="Situação"
            attribute="situation"
            value="{{ $data['situation'] }}"
        />
    </div>
</div>

<div class="row my-1">
    <div class="col-6">
        <x-bootstrap.forms.input.read-only
            id="attributeFiscalId"
            label="CNPJ"
            attribute="fiscalId"
            value="{{ $data['fiscalId'] }}"
        />
    </div>

    <div class="col-6">
        <x-bootstrap.forms.input.read-only
            id="attributeContactName"
            label="Fornecedor"
            attribute="contactName"
            value="{{ $data['contactName'] }}"
        />
    </div>
</div>

<div class="row my-1">
    <div class="col-4">
        <x-bootstrap.forms.input.read-only
            id="attributeValue"
            label="Valor da nota"
            attribute="value"
            value="{{ $data['value'] }}"
        />
    </div>

    <div class="col-4">
        <x-bootstrap.forms.input.read-only
            id="attributeFreightValue"
            label="Valor do Frete"
            attribute="freightValue"
            value="{{ $data['freightValue'] }}"
        />
    </div>

    <div class="col-4">
        <x-bootstrap.forms.input.read-only
            id="attributeInsurancePrice"
            label="Valor do Seguro"
            attribute="insuranceValue"
            value="{{ $data['insuranceValue'] }}"
        />
    </div>
</div>
