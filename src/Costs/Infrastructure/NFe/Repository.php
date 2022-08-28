<?php

namespace Src\Costs\Infrastructure\NFe;

use SimpleXMLElement;
use Src\Costs\Domain\Models\PurchaseItem;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem as PurchaseItemModel;
use Src\Costs\Infrastructure\NFe\Data\Product;
use Src\Costs\Infrastructure\NFe\Mappers\PurchaseItemMapper;

class Repository implements NFeRepository
{
    public function __construct(
        private PurchaseItemMapper $mapper
    ) {
    }

    /**
     * @return PurchaseItem[]
     */
    public function getPurchaseItems(SimpleXMLElement $xml): array
    {
        $items = $this->decodeItems($xml);

        foreach ($items as $item) {
            $attributes = $this->mapper->map(Product::fromArray($item));
            $data[] = new PurchaseItemModel($attributes);
        }

        return $data ?? [];
    }

    private function decodeItems(SimpleXMLElement $xml): array
    {
        $items = json_decode(
            json_encode((array) $xml->NFe->infNFe),
            true
        );

        if ($xml->NFe->infNFe->det->count() === 1) {
            return [$items['det']];
        }

        return $items['det'];
    }
}
