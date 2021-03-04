<?php

namespace Database\Factories;

use App\Models\PriceCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PriceCampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PriceCampaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'products' => [
                [
                    'sku' => $this->faker->numberBetween(1111, 4444),
                    'purchasePrice' => $this->faker->numberBetween(25, 150),
                    'stock' => $this->faker->randomDigit,
                    'lastSaleAt' => $this->faker->dateTimeBetween('-18 weeks', '-1 weeks'),
                    'purchasedAt' => $this->faker->dateTimeBetween('-6 weeks', '-3 weeks'),
                ],
            ],
            'stores' => [
                [
                    'code' => 'magalu',
                    'name' => 'Magazine Luiza',
                    'commission' => 12.8,
                ]
            ],
        ];
    }
}
