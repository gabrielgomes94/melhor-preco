<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Bling\Client;

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

    public function get(Request $request, $sku)
    {
        $data = $this->blingClient->get($sku);

        $data = $data['retorno'];
        if (array_key_exists('erros', $data)) {
            $error = '404 not found';

            return response()->json($error);
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
}
