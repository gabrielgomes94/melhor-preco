<?php

namespace Src\Products\Application\Exports;

use Src\Products\Domain\Entities\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\MoneyFormatter;
use NumberFormatter;

class BlingPriceExport implements FromArray, WithCustomCsvSettings
{
    /**
     * @var Product[] $products
     */
    private array $products;
    private string $store;
    private MoneyFormatter $moneyFormatter;

    /**
     * @param Product[] $products
     * @param string $store
     */
    public function __construct(array $products, string $store)
    {
        $this->products = $products;
        $this->store = $store;

        $currencies = new ISOCurrencies();
        $numberFormatter = new NumberFormatter('nl_NL', NumberFormatter::DECIMAL);
        $this->moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
    }

    public function array(): array
    {
        $firstRow = [
            'IdProduto',
            'ID na Loja',
            'Nome',
            'Código',
            'Preco',
            'PrecoPromocional',
            'ID do Fornecedor',
            'ID da Marca',
            'Link Externo',
            'Nome Loja (Multilojas)'
        ];


        $prices = array_map(function (Product $product) {
            $post = $product->post($this->store);
            $price = $this->moneyFormatter->format($post->price());

            return [
                $product->erpId(),
                $post->store()->storeSkuId(),
                $product->name(),
                $product->sku(),
                $price,
                $price,
                '',
                '',
                '',
                $post->store()->name(),
            ];
        }, $this->products);

        return array_merge([$firstRow], $prices);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
