<x-bootstrap.forms.form.post action="{{ route('marketplaces.doSetCommissionByCategory', $marketplaceSlug) }}">
    <div class="mt-2">
        <x-bootstrap.forms.input.text
            attribute="commissionMaximumCap"
            id="commission-input"
            label="Limite máximo de Comissão (R$)"
            value=""
        />
    </div>

    <div class="mt-2">
        <h4>Commissões</h4>

        @foreach ($categories ?? [] as $category)
            <div data-parent-id="{{ $category['parentId'] }}" class="row category-commission-row">
                @for ($i = 0; $i < $category['spacing']['level']; $i++)
                    <div class="col-1"></div>
                @endfor

                <div class="col-{{ $category['spacing']['componentSpace'] }}">
                    <x-bootstrap.forms.input.hidden
                        name="categoryId[]"
                        class="input-category-id"
                        componentId="categoryId-input-{{ $category['categoryId'] }}"
                        label=""
                        value="{{ $category['categoryId'] }}"
                    />

                    <x-bootstrap.forms.input.number
                        name="commission[]"
                        id="commission-input-{{ $category['categoryId'] }}"
                        class="input-commission"
                        label="{{ $category['name'] }}"
                        value="{{ $category['commission'] }}"
                    />
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-3">
        <x-bootstrap.forms.input.submit label="Salvar" />
    </div>
</x-bootstrap.forms.form.post>
