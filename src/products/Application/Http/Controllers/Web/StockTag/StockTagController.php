<?php

namespace Src\Products\Application\Http\Controllers\Web\StockTag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Application\Services\StockTag\GenerateQRCode;

class StockTagController extends Controller
{
    private GenerateQRCode $generateQRCodeService;

    public function __construct(GenerateQRCode $generateQRCodeService)
    {
        $this->generateQRCodeService = $generateQRCodeService;
    }

    public function createQrCode(Request $request)
    {
        return view('pages.products.stock_tags.generate_qr_code');
    }

    public function generateQrCode(Request $request)
    {
        $products = $request->input('products');
        $qrCodes = $this->generateQRCodeService->generate($products);

        return view('pages.products.stock_tags.list', ['products' => $qrCodes]);
    }
}
