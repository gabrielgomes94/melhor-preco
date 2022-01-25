<div class="d-flex flex-column justify-content-around">
    <x-template.forms.get
        :action="route('pricing.calculator.massCalculation', $store->slug())"
        :formId="$formId"
    >
        <div class="mb-4">
            <label class="my-1 me-2" for="category">Categoria</label>
            <select class="form-select" name="category" id="category" aria-label="Seleciona uma categoria">
                <option value=""></option>
                @foreach ($filter['categories'] as $category)
                    <option value="{{ $category['category_id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <x-template.input.percentage
                attribute="profitMargin"
                label="Margem de Lucro desejada"
                value="{{ $massCalculation['profitMargin'] ?? '' }}"
            />
        </div>

        <div class="mb-4">
            <x-template.input.percentage
                attribute="commission"
                label="Commissão"
                value="{{ $massCalculation['commission'] ?? '' }}"
            />
        </div>

    </x-template.forms.get>
</div>
