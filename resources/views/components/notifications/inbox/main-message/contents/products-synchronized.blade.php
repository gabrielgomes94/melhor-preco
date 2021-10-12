<div>
    <h6>Novos produtos criados: {{ $notification->content()['created'] ?? '' }}</h6>
    <h6>Produtos atualizados: {{ $notification->content()['updated'] ?? '' }}</h6>
</div>
