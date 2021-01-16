<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Bling\Product\Client;

class ProductController extends BaseController
{
    /**
     * @var Client
     */
    private $blingClient;

    public function __construct(Client $blingClient)
    {
        $this->blingClient = $blingClient;
    }

    public function getWithImage(Request $request, $sku)
    {
        $data = $this->blingClient->get($sku);

        if (array_key_exists('errors', $data)) {
            $errors = $data['errors'];

            return response()->json(compact('errors'));
        }

        $data = $data['retorno'];
        if (array_key_exists('errors', $data)) {
            $errors = '404 not found';

            return response()->json(compact('errors'));
        }

        $data = $data['produtos'][0]['produto'];

        $data = [
            'codigo' => $data['codigo'],
            'descricao' => $data['descricao'],
            'marca' => $data['marca'],
            'descricaoCurta' => $data['descricaoCurta'],
        ];

        return response()->json($data);
    }

    public function getWithStock(Request $request, $sku)
    {
        $data = $this->blingClient->getWithStock($sku);

        return response()->json($data);
    }
}
