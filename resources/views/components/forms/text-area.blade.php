
<div class="form-group w-100">
    <label for="{{ $id }}">{{ $label }}</label>
{{--    <input type="{{ $type }}" class="form-control w-100 {{ $class }}" id="{{ $id }}" placeholder="{{ $placeholder }}" name="{{ $name }}" value="{{ $value }}">--}}
    <textarea class="form-control" id="{{ $id }}" name="{{ $id }}" rows="3">{{ $value }}</textarea>
</div>
