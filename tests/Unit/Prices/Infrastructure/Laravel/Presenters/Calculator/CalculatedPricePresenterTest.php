<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Math\Transformers\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculatedPricePresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_calculated_price_when_form_is_not_given(): void
    {
        // Arrange
        $presenter = new CalculatedPricePresenter(
            new CommissionRepository()
        );

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user);
        $calculatedPrice = new CalculatedPrice(
            new CostPrice(
                550.0,
                20.0,
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            899.9,
            100.0,
            0.0,
        );
        $priceCalculatedFromProduct = new PriceCalculatedFromProduct($product, $marketplace, $calculatedPrice);

        // Act
        $result = $presenter->present($priceCalculatedFromProduct);

        // Assert
        $expected = [
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
            ]
        ];
        $this->assertSame($expected, $result);
    }
}
