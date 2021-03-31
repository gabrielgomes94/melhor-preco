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
            'name' => 'Cadeira de Alimentação',
            'products' => [
                [
                    'sku' => '1232',
                    'purchase' => [
                        'price' => 35.5,
                        'date' => $this->faker->dateTimeBetween('-6 weeks', '-3 weeks'),
                    ],
                    'lastSale' => [
                        'date' => $this->faker->dateTimeBetween('-6 weeks', '-3 weeks'),
                        'price' => 150,
                        'profit' => 25,
                    ],
                    'stock' => $this->faker->randomDigit,
                    'prices' => [
                        [
                            'store' => 'magalu',
                            'value' => 102.2,
                            'profit' => 10,
                        ],
                        [
                            'store' => 'b2w',
                            'value' => 106.2,
                            'profit' => 14,
                        ],
                    ],
                    'taxes' => [
                        [
                            'type' => 'in',
                            'value' => 0.04,
                        ],
                        [
                            'type' => 'in',
                            'value' => 0.1,
                        ],
                        [
                            'type' => 'out',
                            'value' => 0.16,
                        ],
                    ],
                ],
            ],
            'stores' => [
                [
                    'code' => 'magalu',
                    'name' => 'Magazine Luiza',
                    'commission' => 12.8,
                    'extra_costs' => 0.0,
                ],
                [
                    'code' => 'b2w',
                    'name' => 'B2W',
                    'commission' => 12.8,
                    'extra_costs' => 5,
                ],
            ],
        ];
    }
}
