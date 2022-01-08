<?php

namespace Src\Costs\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Src\Products\Application\Http\Requests\UploadSpreadsheetRequest;
use Src\Products\Application\UseCases\UploadSpreadsheet;

class UpdateICMSController extends Controller
{
    private UploadSpreadsheet $uploadSpreadsheet;

    public function __construct(UploadSpreadsheet $uploadSpreadsheet)
    {
        $this->uploadSpreadsheet = $uploadSpreadsheet;
    }

    public function updateICMS()
    {
        return view('pages.products.Costs.upload_icms');
    }

    public function doUpdateICMS(UploadSpreadsheetRequest $request)
    {
        try {
            $this->uploadSpreadsheet->upload($this->getFileUrl($request), $request->user()->id);

            session()->flash('message', $this->successfulMessage());
        } catch (ValidationException $e) {
            session()->flash('error', 'É necessário enviar um arquivo .xlsx ou .csv.');
        }

        return view('pages.products.Costs.upload_icms');
    }

    private function getFileUrl(Request $request): string
    {
        $file = $request->file('file');

        return Storage::putFileAs(
            "spreadsheets/products/update_costs",
            $file,
            $file->getClientOriginalName()
        );
    }

    private function successfulMessage(): string
    {
        return 'A planilha foi enviada com sucesso para ser processada. Em breve você receberá um email informando o resultado dessa operação.';
    }
}
