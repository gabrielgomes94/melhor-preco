<div>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
                        @csrf

                        <x-forms.input
                            name="commission"
                            label="Comissão"
                            id="commission"
                            class="input-comission"
                            type="text"
                            placeholder="18,8%"
                            value="{{ $priceParams['sku'] ?? '' }}"
                            disabled="true"
                        ></x-forms.input>

                        <x-forms.input
                            name="commission"
                            label="Frete"
                            id="commission"
                            class="input-comission"
                            type="text"
                            placeholder="18,8%"
                            value="{{ $priceParams['sku'] ?? '' }}"
                            disabled="true"
                        ></x-forms.input>

                        <x-forms.input
                            name="commission"
                            label="Custos Adicionais"
                            id="commission"
                            class="input-comission"
                            type="text"
                            placeholder="18,8%"
                            value="{{ $priceParams['sku'] ?? '' }}"
                            disabled="true"
                        ></x-forms.input>

                        <div class="d-inline-flex justify-content-between w-100">
                            <x-forms.input
                                name="commission"
                                label="Margem"
                                id="commission"
                                class="input-comission"
                                type="text"
                                placeholder="18,8%"
                                value="{{ $priceParams['sku'] ?? '' }}"
                                disabled="true"
                            ></x-forms.input>

                            <x-forms.input
                                name="commission"
                                label="Preço de Venda"
                                id="commission"
                                class="input-comission"
                                type="text"
                                placeholder="18,8%"
                                value="{{ $priceParams['sku'] ?? '' }}"
                                disabled="true"
                            ></x-forms.input>
                        </div>

                        <input type="submit"
                               class="btn btn-dark d-block w-100 mx-auto m-2"
                               value="Calcular" />
                    </form>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
                        @csrf

                        <x-forms.input
                            name="commission"
                            label="Preço de Venda"
                            id="commission"
                            class="input-comission"
                            type="text"
                            placeholder="R$ 250,90"
                            value="{{ $priceParams['sku'] ?? '' }}"
                            disabled="true"
                        ></x-forms.input>

                        <x-forms.input
                            name="commission"
                            label="Lucro"
                            id="commission"
                            class="input-comission"
                            type="text"
                            placeholder="R$ 62,90"
                            value="{{ $priceParams['sku'] ?? '' }}"
                            disabled="true"
                        ></x-forms.input>

                        <x-forms.input
                            name="commission"
                            label="Margem"
                            id="commission"
                            class="input-comission"
                            type="text"
                            placeholder="23,95%"
                            value="{{ $priceParams['sku'] ?? '' }}"
                            disabled="true"
                        ></x-forms.input>

                        <input type="submit"
                               class="btn btn-dark d-block w-100 mx-auto m-2"
                               value="Salvar" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
