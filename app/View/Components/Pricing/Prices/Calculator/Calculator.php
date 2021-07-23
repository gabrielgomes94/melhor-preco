<?php

namespace App\View\Components\Pricing\Prices\Calculator;

use App\Presenters\Pricing\Post\MagaluPost;
use App\Presenters\Pricing\Post\Post;
use Illuminate\View\Component;

class Calculator extends Component
{
    public string $productId;
    public Post $price;

    public function __construct(string $productId, Post $price)
    {
        $this->productId = $productId;
        $this->price = $price;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->price instanceof MagaluPost) {
            $discountedPrice = [
                'price' => $this->price->discountedPrice,
                'profit' => $this->price->discountedProfit,
                'margin' => $this->price->discountedMargin,
            ];

            return view('components.pricing.prices.calculator.magalu-calculator', compact('discountedPrice'));
        }

        return view('components.pricing.prices.calculator.calculator');
    }
}
