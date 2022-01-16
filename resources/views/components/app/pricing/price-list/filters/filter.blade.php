<div class="d-flex flex-column justify-content-around">
    <x-app.pricing.products.single-store.filter-kits :store="$store" />

    <x-template.forms.get
        :action="route('pricing.priceList.byStore', $store->slug())"
        :formId="$formId"
    >
        <div class="border-top my-2 py-2">
            <x-app.pricing.products.single-store.filter-by-profit
                :store="$store"
                :minimumProfit="$minimumProfit"
                :maximumProfit="$maximumProfit"
                :sku="$sku"
                :formId="$formId"
            />
        </div>

        <div class="mb-4">
            <label class="my-1 me-2" for="country">Categoria</label>
            <select class="form-select" name="category" id="country" aria-label="Default select example">
                @foreach ($filter['categories'] as $category)
                    <option value="{{ $category['category_id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
    </x-template.forms.get>
</div>
