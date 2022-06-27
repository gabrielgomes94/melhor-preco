<?php

namespace Src\Products\Domain\Events;

// @todo: usar esse evento para notificar um listener que atualizará a lucratividade do produto após seu custo ter sido atualizado
// @todo: mover esse evento para o módulo de custos
// @todo: enriquecer o evento com as informações relevantes
class ProductCostsUpdated
{
    private string $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }
}
