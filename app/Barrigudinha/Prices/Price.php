<?php
namespace App\Barrigudinha\Prices;

class Price
{
    public $sku;

    public $purchasePrice;

    public $costPrice;

    public $taxes;

    public $profitMargin;

    public $commission;

    public $salePrice;

    public $freight;

    public function __construct(array $data)
    {
        $this->sku = $data['sku'];
        $this->purchasePrice = $data['purchasePrice'];
        $this->taxes = $data['taxes'] ?? [];
        $this->commission = $data['commission'];
        $this->profitMargin = $data['profitMargin'];
        $this->freight = $data['freight'];
    }
}
