<div>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <form method="post" action="{{ route('prices.calculate_single') }}" enctype="multipart/form-data">
                        @csrf

                        <x-forms.input.percentage
                            attribute="commission"
                            label="Comissão"
                            value="{{ $price->commission }}"
                        >
                        </x-forms.input.percentage>

                        <x-forms.input.money
                            attribute="additionalCosts"
                            label="Custos Adicionais"
                            value="{{ $price->additionalCosts }}"
                        >
                        </x-forms.input.money>

                        <div class="d-inline-flex justify-content-between w-100">
                            <x-forms.input.percentage
                                attribute="margin"
                                label="Margem"
                                value="{{ $price->margin }}"
                            >
                            </x-forms.input.percentage>

                            <x-forms.input.money
                                attribute="value"
                                label="Preço"
                                value="{{ $price->value }}"
                            >
                            </x-forms.input.money>
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

                        <x-forms.input.money
                            attribute="value"
                            label="Preço"
                            value="{{ $price->value }}"
                        >
                        </x-forms.input.money>

                        <x-forms.input.money
                            attribute="profit"
                            label="Lucro"
                            value="{{ $price->profit }}"
                        >
                        </x-forms.input.money>

                        <x-forms.input.percentage
                            attribute="margin"
                            label="Margem"
                            value="{{ $price->margin }}"
                        >
                        </x-forms.input.percentage>

                        <input type="submit"
                               class="btn btn-dark d-block w-100 mx-auto m-2"
                               value="Salvar" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
