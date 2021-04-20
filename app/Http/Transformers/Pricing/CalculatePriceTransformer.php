<?php


namespace App\Http\Transformers\Pricing;



use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Data\Tax;
use Illuminate\Http\Request;
use Money\Money;

class CalculatePriceTransformer
{
    public Money $purchasePrice;
    public float $taxIPI;
    public float $taxICMSDifference;
    public float $taxSimplesNacional;
    public float $commission;
    public Money $additionalCosts;
    public ?float $desiredMargin;
    public ?Money $desiredSellingPrice;

    public function __construct(Request $request, Product $product)
    {
        $this->purchasePrice = Money::BRL((int) ($product->purchasePrice() * 100));
        $this->taxIPI = $product->tax(Tax::IPI)->rate / 100;
        $this->taxICMSDifference = $product->tax(Tax::ICMS)->rate / 100;
        $this->taxSimplesNacional = $product->tax(Tax::SIMPLES_NACIONAL)->rate / 100;
        $this->commission =  $request->input('commission') / 100;
        $this->desiredMargin = $request->input('desiredMargin') / 100 ?? null;

        $this->additionalCosts = Money::BRL((int) ($request->input('additionalCosts')  * 100));
        $this->desiredSellingPrice = Money::BRL((int) ($request->input('desiredPrice') * 100 )) ?? null;
    }

    public function transform()
    {
    }

}

