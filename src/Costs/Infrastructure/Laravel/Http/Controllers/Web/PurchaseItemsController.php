<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Domain\UseCases\Contracts\LinkProductToPurchaseItem;

class PurchaseItemsController extends Controller
{
    private LinkProductToPurchaseItem $linkProductToPurchaseItem;

    public function __construct(LinkProductToPurchaseItem $linkProductToPurchaseItem)
    {
        $this->linkProductToPurchaseItem = $linkProductToPurchaseItem;
    }

    public function linkProduct(Request $request)
    {
        $data = $request->all();
        $this->linkProductToPurchaseItem->linkManyProducts(collect($data['products']));

        return redirect()->back();
    }
}