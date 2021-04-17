<x-layout>

    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Nome da Precificação</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nome do Produto</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <x-pricing.products.update-form :productInfo="$productInfo" :pricingId="$pricingId" />
            </div>
            <div class="col-sm-8">
                <x-pricing.products.prices-accordion />
            </div>
        </div>
    </div>
</x-layout>
