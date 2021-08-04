<?php

namespace App\View\Components\Pricing\Prices\Calculator;

use App\Presenters\Pricing\Post\Contracts\HasSecondaryPrice;
use App\Presenters\Pricing\Post\MagaluPost;
use App\Presenters\Pricing\Post\MercadoLivrePost;
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
        if ($this->price instanceof HasSecondaryPrice) {
            $secondaryPrice = $this->price->secondaryPrice();

            if ($this->price instanceof MagaluPost) {
                return view('components.pricing.prices.calculator.magalu-calculator', compact('secondaryPrice'));
            }

            if ($this->price instanceof MercadoLivrePost) {
                return view('components.pricing.prices.calculator.mercado-livre-calculator', compact('secondaryPrice'));
            }
        }

        return view('components.pricing.prices.calculator.calculator');
    }
}
