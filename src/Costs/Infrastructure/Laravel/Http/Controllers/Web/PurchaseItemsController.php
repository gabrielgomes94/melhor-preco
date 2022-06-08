<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Domain\UseCases\Contracts\LinkProductToPurchaseItem;
use Src\Costs\Infrastructure\Laravel\Http\Requests\LinkProductsRequest;

class PurchaseItemsController extends Controller
{
    private LinkProductToPurchaseItem $linkProductToPurchaseItem;

    public function __construct(LinkProductToPurchaseItem $linkProductToPurchaseItem)
    {
        $this->linkProductToPurchaseItem = $linkProductToPurchaseItem;
    }

    public function linkProduct(LinkProductsRequest $request)
    {
        $data = $request->validated();

        $this->linkProductToPurchaseItem->linkManyProducts($data['products']);

        return redirect()->back();
    }
}
