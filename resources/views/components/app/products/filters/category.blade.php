<label class="my-1 me-2" for="country">Categoria</label>
<select class="form-select" name="category" id="country" aria-label="Seleciona uma categoria">
    <option value=""></option>
    @foreach ($filter['categories'] ?? [] as $category)
        <option value="{{ $category['category_id'] }}">{{ $category['name'] }}</option>
    @endforeach
</select>
