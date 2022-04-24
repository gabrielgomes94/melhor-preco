<div class="accordion" id="{{ $accordionId }}">
    <div class="accordion-item">
        @isset($accordionHeader)
            <x-bootstrap.accordions.accordion-header
                :accordionHeaderId="$accordionHeaderId"
                :accordionBodyId="$accordionBodyId"
                :accordionHeader="$accordionHeader"
            >
            </x-bootstrap.accordions.accordion-header>

        @endisset

        @isset($accordionBody)
                <x-bootstrap.accordions.accordion-body
                    :accordionBodyId="$accordionBodyId"
                    :accordionId="$accordionId"
                    :accordionHeaderId="$accordionHeaderId"
                    :accordionBody="$accordionBody"
                >
                </x-bootstrap.accordions.accordion-body>
        @endisset
    </div>
</div>
