<x-bootstrap.card.basic.card :class="{{$class ?? '}}">
    @isset($header)
        <x-bootstrap.card.basic.card-header>
            {{ $header }}
        </x-bootstrap.card.basic.card-header>
    @endisset

    <x-bootstrap.card.basic.card-body>
        {{ $body }}
    </x-bootstrap.card.basic.card-body>

    @isset($footer)
        <x-bootstrap.card.basic.card-footer>
            {{ $footer }}
        </x-bootstrap.card.basic.card-footer>
    @endisset
</x-bootstrap.card.basic.card>
