<h2 class="accordion-header" id="price-accordion-{{ $price->id }}">
    <button class="accordion-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#price-accordion-collapse-{{ $price->id }}"
            aria-expanded="true"
            aria-controls="price-accordion-collapse-{{ $price->id }}"
    >

        <div class="d-flex justify-content-between w-100">
            <div class="">{{ $price->store }}</div>
            <div>
                R$ {{ $price->value }}<br>
                R$ {{ $price->profit }} | {{ round($price->margin, 2) }} %
            </div>
        </div>
    </button>
</h2>
