<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculatorPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_calculator_when_there_is_no_form_data(): void
    {
        // Arrange
        $presenter = app(CalculatorPresenter::class);

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user, [
            PriceData::build($marketplace, ['value' => 899.9]),
        ]);
        $calculatedPrice = new CalculatedPrice(
            new CostPrice(
                MoneyTransformer::toMoney(550.0),
                MoneyTransformer::toMoney(20.0),
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            MoneyTransformer::toMoney(899.9),
            MoneyTransformer::toMoney(100.0),
            MoneyTransformer::toMoney(0.0),
        );
        $priceCalculatedFromProduct = new PriceCalculatedFromProduct($product, $marketplace, $calculatedPrice);

        // Act
        $result = $presenter->present($priceCalculatedFromProduct);

        // Assert
        $expected = [
            'calculatorForm' => [
                'marketplaceName' => 'Shopee',
                'marketplaceSlug' => 'shopee',
                'commission' => 12.0,
                'discount' => 0.0,
                'desiredPrice' => 899.9,
                'productId' => '1234',
                'freight' => 0.0,
            ],
            'calculatedPrice' => [
                'formatted' => [
                    'commission' => 'R$ 100,00',
                    'commissionRate' => 12.0,
                    'costs' => 'R$ 764,77',
                    'differenceICMS' => 'R$ 45,73',
                    'freight' => 'R$ 0,00',
                    'marketplaceSlug' => 'shopee',
                    'margin' => '15,02 %',
                    'profit' => 'R$ 135,13',
                    'purchasePrice' => 'R$ 550,00',
                    'suggestedPrice' => 'R$ 899,90',
                    'taxSimplesNacional' => 'R$ 49,04',
                ],
                'raw' => [
                    'margin' => 15.02,
                    'profit' => 135.13,
                ],
            ],
            'productInfo' => [
                'id' => '1234',
                'header' => '1234 - Carrinho de Bebê',
                'currentPrice' => 'R$ 899,90',
            ],
            'costsForm' => [
                'purchasePrice' => 449.9,
                'taxICMS' => 12.0,
                'additionalCosts' => 0.0,
            ],
            'priceId' => '1',
            'marketplacesList' => [
                [
                    'name' => 'Shopee',
                    'slug' => 'shopee',
                    'selected' => true,
                ]
            ],
            'costs' => [],
        ];
        $this->assertSame($expected, $result);
    }

    public function test_should_present_calculator_when_there_is_form_data(): void
    {
        // Arrange
        $presenter = app(CalculatorPresenter::class);

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user, [
            PriceData::build($marketplace, ['value' => 899.9]),
        ]);
        $calculatedPrice = new CalculatedPrice(
            new CostPrice(
                MoneyTransformer::toMoney(550.0),
                MoneyTransformer::toMoney(20.0),
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            MoneyTransformer::toMoney(929.9),
            MoneyTransformer::toMoney(100.0),
            MoneyTransformer::toMoney(0.0),
        );
        $priceCalculatedFromProduct = new PriceCalculatedFromProduct($product, $marketplace, $calculatedPrice);
        $form = new CalculatorForm(
            929.90,
            Percentage::fromPercentage(11.0),
            Percentage::fromPercentage(0),
            0.0
        );

        // Act
        $result = $presenter->present($priceCalculatedFromProduct, $form);

        // Assert
        $expected = [
            'calculatorForm' => [
                'marketplaceName' => 'Shopee',
                'marketplaceSlug' => 'shopee',
                'commission' => 11.0,
                'discount' => 0.0,
                'desiredPrice' => 929.9,
                'productId' => '1234',
                'freight' => 0.0,
            ],
            'calculatedPrice' => [
                'formatted' => [
                    'commission' => 'R$ 100,00',
                    'commissionRate' => 11.0,
                    'costs' => 'R$ 766,41',
                    'differenceICMS' => 'R$ 45,73',
                    'freight' => 'R$ 0,00',
                    'marketplaceSlug' => 'shopee',
                    'margin' => '17,58 %',
                    'profit' => 'R$ 163,49',
                    'purchasePrice' => 'R$ 550,00',
                    'suggestedPrice' => 'R$ 929,90',
                    'taxSimplesNacional' => 'R$ 50,68',
                ],
                'raw' => [
                    'margin' => 17.58,
                    'profit' => 163.49,
                ],
            ],
            'productInfo' => [
                'id' => '1234',
                'header' => '1234 - Carrinho de Bebê',
                'currentPrice' => 'R$ 899,90',
            ],
            'costsForm' => [
                'purchasePrice' => 449.9,
                'taxICMS' => 12.0,
                'additionalCosts' => 0.0,
            ],
            'priceId' => '2',
            'marketplacesList' => [
                [
                    'name' => 'Shopee',
                    'slug' => 'shopee',
                    'selected' => true,
                ]
            ],
            'costs' => [],
        ];
        $this->assertSame($expected, $result);
    }
}
