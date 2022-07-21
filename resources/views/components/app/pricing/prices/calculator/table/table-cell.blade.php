<tr>
    @if($bold ?? false)
        <td>
                <b>
                    {{ $label }}
                </b>
        </td>
        <td id="{{ $id }}">
            <span class="{{ $class ?? '' }}">
                <b>{{ $value ?? '' }}</b>
            </span>
        </td>
    @else
        <td>
            {{ $label }}
        </td>
        <td id="{{ $id }}">
            <span class="{{ $class ?? '' }}">
                {{ $value ?? '' }}
            </span>
        </td>
    @endif
</tr>
