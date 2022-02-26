@foreach ($product['images'] ?? [] as $image)
    <img src="{{ $image }}" width="128">
@endforeach
