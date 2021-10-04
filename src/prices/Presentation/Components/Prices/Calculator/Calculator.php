<?php

namespace Src\Prices\Presentation\Components\Prices\Calculator;

use App\Presenters\Pricing\Post\Contracts\HasSecondaryPrice;
use App\Presenters\Pricing\Post\MagaluPost;
use App\Presenters\Pricing\Post\MercadoLivrePost;
use App\Presenters\Pricing\Post\Post;
use Illuminate\View\Component;

class Calculator extends Component
{
    public string $productId;
    public Post $price;

    private array $specificViews = [
        MagaluPost::class => 'components.pricing.prices.calculator.magalu-calculator',
        MercadoLivrePost::class =>  'components.pricing.prices.calculator.mercado-livre-calculator'
    ];

    public function __construct(string $productId, Post $price)
    {
        $this->productId = $productId;
        $this->price = $price;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->price instanceof HasSecondaryPrice) {
            $secondaryPrice = $this->price->secondaryPrice();

            foreach ($this->specificViews as $class => $view) {
                if ($this->price instanceof $class) {
                    return view($view, compact('secondaryPrice'));
                }
            }
        }

        return view('components.pricing.prices.calculator.calculator');
    }
}
