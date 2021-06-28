@if ($value > 0)
    <div class="text-success">
        {{ $preffix ?? '' }} {{ $value }} {{ $suffix ?? '' }}
    </div>
@else
    <div class="text-danger">
        {{ $preffix ?? '' }} {{ $value }} {{ $suffix ?? '' }}
    </div>
@endif
