<?php

namespace Src\Products\Presentation\Http\Controllers\Web\StockTag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Application\UseCases\GenerateQRCode;
use Src\Products\Presentation\Presenters\StockTags\PdfPresenter;

class StockTagController extends Controller
{
    private \Src\Products\Application\UseCases\GenerateQRCode $generateQRCodeService;
    private PdfPresenter $pdfPresenter;

    public function __construct(GenerateQRCode $generateQRCodeService, PdfPresenter $pdfPresenter)
    {
        $this->generateQRCodeService = $generateQRCodeService;
        $this->pdfPresenter = $pdfPresenter;
    }

    public function createQrCode(Request $request)
    {
        return view('pages.products.stock_tags.generate_qr_code');
    }

    public function generateQrCode(Request $request)
    {
        $products = $request->input('products');
        $qrCodes = $this->generateQRCodeService->generate($products);

        $pdf = $this->pdfPresenter->generate($qrCodes);

        return $pdf->download('etiquetas.pdf');
    }
}
