<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Calculator\Application\Services\CalculatePrice;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\Percentage;
use Src\Prices\Domain\UseCases\Price\UpdatePrice as UpdatePriceInterface;
use Src\Prices\Infrastructure\Laravel\Services\Products\Commands\UpdateCommand;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Repositories\PostRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class UpdatePrice implements UpdatePriceInterface
{
    private CalculatePrice $calculatePrice;
    private UpdateCommand $updatePriceService;
    private PostRepository $postRepository;
    private PostFactory $postFactory;

    public function __construct(
        CalculatePrice $calculatePrice,
        UpdateCommand  $updatePriceService,
        PostRepository $postRepository,
        PostFactory    $postFactory
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->updatePriceService = $updatePriceService;
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
    }

    public function updatePrice(
        Product $product,
        Marketplace $marketplace,
        float $priceValue,
        ?float $commission = null
    ): bool
    {
        $products = $this->getProducts($product);

        foreach ($products as $product) {
            $post = $this->postRepository->get($product, $marketplace);

            if (!$post) {
                return false;
            }

            $price = $this->calculatePrice->calculate(
                ProductData::fromModel($product),
                $marketplace,
                $priceValue,
                Percentage::fromFraction($commission ?? $this->getCommissionRate($post))
            );

            $post = $this->postFactory->updatePrice($post, $price);
            $this->updatePriceService->execute($product->getSku(), $post);
        }

        return true;
    }

    /**
     * @return Product[]
     */
    private function getProducts(Product $product): array
    {
        $products[] = $product;

        foreach ($product->getVariations()->get() as $variation) {
            $products[] = $variation;
        }

        return $products;
    }

    protected function getCommissionRate(Post $post): float
    {
        return $post->getPrice()->getCommission()->get();
    }
}
