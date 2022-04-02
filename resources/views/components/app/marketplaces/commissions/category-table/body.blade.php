<tbody>
    @foreach ($categories ?? [] as $category)
    <tr class="category-commission-row">
        <td>
            <x-bootstrap.forms.input.read-only
                name="categoryName[]"
                id="name-input-{{ $category['categoryId'] }}"
                label=""
                value="{{ $category['name'] }}"
            />

            <x-bootstrap.forms.input.hidden
                name="categoryId[]"
                class="input-category-id"
                componentId="categoryId-input-{{ $category['categoryId'] }}"
                label=""
                value="{{ $category['categoryId'] }}"
            />
        </td>
        <td data-parent-id="{{ $category['parentId'] }}">
            <x-bootstrap.forms.input.number
                name="commission[]"
                id="commission-input-{{ $category['categoryId'] }}"
                class="input-commission"
                label=""
                value="{{ $category['commission'] }}"
            />
        </td>
    </tr>
    @endforeach
</tbody>
