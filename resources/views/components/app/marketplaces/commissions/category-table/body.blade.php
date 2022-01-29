<tbody>
    @foreach ($categories ?? [] as $category)
    <tr>
        <td>
            <x-bootstrap.forms.input.read-only
                name="category"
                id="name-input-{{ $category['categoryId'] }}"
                label=""
                value="{{ $category['name'] }}"
            />

            <x-bootstrap.forms.input.hidden
                name="category"
                id="categoryId-input-{{ $category['categoryId'] }}"
                label=""
                value="{{ $category['categoryId'] }}"
            />
        </td>
        <td data-parent-id="{{ $category['parentId'] }}">
            <x-bootstrap.forms.input.percentage
                name="commission"
                id="commission-input-{{ $category['categoryId'] }}"
                label=""
                value="{{ $category['name'] }}"
            />
        </td>
    </tr>
    @endforeach
</tbody>
