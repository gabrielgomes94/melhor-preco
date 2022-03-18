<x-bootstrap.forms.form.post
    action="{{ route('promotions.doCalculate') }}"
    id="calculate-promotions-form"
>
    <x-bootstrap.forms.input.text
        attribute="promotionName"
        id="promotion-name"
        label="Nome da promoção"
        value=""
    >
    </x-bootstrap.forms.input.text>

    <x-bootstrap.forms.input.text
        attribute="sellerSubsidy"
        id="seller"
        label="Subsídio do vendedor"
        value=""
    >
    </x-bootstrap.forms.input.text>

    <x-bootstrap.forms.input.text
        attribute="marketplaceSubsidy"
        id="marketplace"
        label="Subsídio do Marketplace"
        value=""
    >
    </x-bootstrap.forms.input.text>

    <x-bootstrap.forms.input.text
        attribute="minimumDiscount"
        id="minimum-discount"
        label="Valor mínimo de desconto"
        value=""
    >
    </x-bootstrap.forms.input.text>

    <x-bootstrap.forms.input.text
        attribute="maximumDiscount"
        id="maximum-discount"
        label="Valor máximo de desconto"
        value=""
    >
    </x-bootstrap.forms.input.text>

    <x-bootstrap.forms.input.text
        attribute="productsMaxLimit"
        id="products-max-limit"
        label="Limite máximo de produtos"
        value=""
    >
    </x-bootstrap.forms.input.text>

    <x-bootstrap.forms.input.submit label="Calcular" />
</x-bootstrap.forms.form.post>
