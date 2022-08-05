<div class="d-flex flex-column justify-content-around">
    <x-bootstrap.forms.form.get
        :action="route('pricing.massCalculate.calculate', $marketplaceSlug)"
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
            <x-bootstrap.forms.input.percentage
                name="markup"
                id="mass-calculation-markup"
                label="Markup"
                value="{{ $massCalculation['markup'] ?? '' }}"
            />
        </div>
    </x-bootstrap.forms.form.get>
</div>
