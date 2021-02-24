<?php
namespace App\Data\Pricing;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ProductPrice extends DataTransferObject
{
    public string $sku;

    public float $purchasePrice;

    public float $commission;

    public float $freight;

    public ?float $profitMargin;

    public ?float $sellingPrice;

    public Taxes $taxes;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'sku' => $request->input('sku'),
            'purchasePrice' => (float) $request->input('price'),
            'taxes' => [
                'ipi' => (float) $request->input('tax-ipi') / 100.0,
                'icmsDifference' => (float)$request->input('tax-icms') / 100.0,
                'simplesNacional' => 4 / 100.0,
            ],
            'commission' => (float) $request->input('commission') / 100.0,
            'profitMargin' => $request->input('profit-margin')
                ? (float) $request->input('profit-margin') / 100.0
                : null,
            'freight' => (float) $request->input('freight') ?? 0,
            'sellingPrice' => (float) $request->input('selling-price')
        ]);
    }
}
