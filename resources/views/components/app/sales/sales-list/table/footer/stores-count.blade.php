<h6>Vendas por Loja</h6>

@foreach ($stores as $store)
    <b>{{ $store['name'] }}:</b> {{ $store['count'] }} <br>
@endforeach
