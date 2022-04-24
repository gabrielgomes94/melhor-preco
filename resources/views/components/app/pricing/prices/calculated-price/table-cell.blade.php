<tr>
    @if($bold ?? false)
        <td>
            <p>
                <b>
                    {{ $label }}
                </b>
            </p>
        </td>
        <td id="{{ $id }}">
            <p class="{{ $class ?? '' }}">
                <b>
                    {{ $value ?? '' }}
                </b>
            </p>
        </td>
    @else
        <td>
            <p>
                {{ $label }}
            </p>
        </td>
        <td id="{{ $id }}">
            <p class="{{ $class ?? '' }}">
                {{ $value ?? '' }}
            </p>
        </td>
    @endif
</tr>
