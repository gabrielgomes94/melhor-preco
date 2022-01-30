<x-template.card.card>
    @isset($header)
        <x-template.card.card-header>
            {{ $header }}
        </x-template.card.card-header>
    @endisset

    <x-template.card.card-body>
        {{ $body }}
    </x-template.card.card-body>

    @isset($footer)
        <x-template.card.card-footer>
            {{ $footer }}
        </x-template.card.card-footer>
    @endisset
</x-template.card.card>
