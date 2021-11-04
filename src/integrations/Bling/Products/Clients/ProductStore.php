<?php

namespace Src\Integrations\Bling\Products\Clients;

use Illuminate\Support\Facades\Http;
use Src\Products\Domain\Contracts\Clients\ProductStore as ProductStoreInterface;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Src\Integrations\Bling\Products\Requests\Transformers\ProductStore as ProductStoreTransformer;
use Src\Integrations\Bling\Products\Responses\BaseResponse;
use Src\Integrations\Bling\Products\Responses\Error;
use Src\Integrations\Bling\Products\Responses\Factories\ErrorResponse;
use Src\Integrations\Bling\Products\Responses\Factories\PriceResponse;
use Src\Integrations\Bling\Products\Responses\Factories\ProductCollectionResponse;
use Src\Integrations\Bling\Products\Responses\Factories\ProductResponse;

class ProductStore implements ProductStoreInterface
{
    private PriceResponse $priceResponse;
    private ProductCollectionResponse $productCollectionResponse;
    private ProductResponse $productResponse;
    private ErrorResponse $errorResponse;

    public function __construct(
        PriceResponse $priceResponse,
        ProductCollectionResponse $productCollectionResponse,
        ProductResponse $productResponse,
        ErrorResponse $errorResponse
    ) {
        $this->priceResponse = $priceResponse;
        $this->productCollectionResponse = $productCollectionResponse;
        $this->productResponse = $productResponse;
        $this->errorResponse = $errorResponse;
    }

    public function get(string $sku, ?string $store = null): BaseResponse
    {
        try {
            if (!$store) {
                $productResponse = Http::withOptions([
                    'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
                    'query' => [
                        'apikey' => env('BLING_API_KEY'),
                        'estoque' => 'S',
                        'imagem' => 'S',
                    ],
                ])->get("$sku/json");

                return $this->productResponse->make($productResponse);
            }

            $response = Http::withOptions([
                'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                    'estoque' => 'S',
                    'imagem' => 'S',
                    'loja' => config("stores_code.{$store}"),
                ],
            ])->get("$sku/json");

            return $this->productResponse->make($response, $store);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function list(int $page = 1, ?string $store = null): BaseResponse
    {
        try {
            $products = Http::withOptions([
                'base_uri' => 'https://Bling.com.br/Api/v2/produtos/',
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                    'estoque' => 'S',
                    'imagem' => 'S',
                    'loja' => config('stores_code.' . $store) ?? null,
                ],
            ])->get("page={$page}/json/");

            if (!$store) {
                return $this->productCollectionResponse->make($products);
            }

            $response = $this->productCollectionResponse->makeWithStore($products, $store);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response;
    }

    public function update(string $sku, string $xml)
    {
        try {
            $response = Http::withOptions([
                'base_uri' => 'https://bling.com.br/Api/v2/produto/',
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                    'xml' => $xml,
                ],
                'headers' => [
                    'Content-Type' => 'text/xml',
                ],
            ])->post("{$sku}/json");


            return $this->productResponse->make($response);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response ?? '';
    }

    /**
     * ToDo: Renomear esse método para updatePrice
     */
    public function updatePrice(string $sku, string $store, string $productStoreSku, string $priceValue): BaseResponse
    {
        try {
            $storeCode = config('stores.' . $store . '.erpCode');
            $xml = ProductStoreTransformer::generateXML($productStoreSku, $priceValue);

            $product = Http::withOptions([
                'base_uri' => 'https://bling.com.br/Api/v2/produto/',
                'query' => [
                    'xml' => $xml,
                ],
                'headers' => [
                    'Content-Type' => 'text/xml',
                ],
            ])->put("{$storeCode}/{$sku}/json");

            $response = $this->priceResponse->make($product, $store);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response;
    }

    private function handleError(string $message): Error
    {
        return $this->errorResponse->make($message);
    }

    private function connectionErrorMessage(): string
    {
        return 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
    }

    private function bizarreErrorMessage(): string
    {
        return 'Aconteceu algum erro bizarro. Contate o suporte.';
    }
}
