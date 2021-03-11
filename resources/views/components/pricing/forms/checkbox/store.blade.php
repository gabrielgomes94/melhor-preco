<div>
    <label>Lojas</label>

    @foreach($stores as $store)
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                name="stores[]"
                value="{{ $store['code'] }}"
                id="store-{{ $store['code'] }}"
            >

            <label class="form-check-label" for="defaultCheck1">
                {{ $store['name'] }} ({{ $store['commission'].'%' }})
            </label>
        </div>
    @endforeach
</div>
