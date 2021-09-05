<?php

namespace App\Http\Controllers\Front\Products\Costs;

use App\Http\Controllers\Controller;
use App\Jobs\Products\Spreadsheets\UploadICMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use function view;

class UpdateICMSController extends Controller
{
    public function updateICMS()
    {
        return view('pages.products.costs.upload_icms');
    }

    public function doUpdateICMS(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt,xlsx',
            ]);

            UploadICMS::dispatch($this->getFileUrl($request));

            session()->flash('message', $this->successfulMessage());
        } catch (ValidationException $e) {
            session()->flash('error', 'É necessário enviar um arquivo .xlsx ou .csv.');
        }

        return view('pages.products.costs.upload_icms');
    }

    private function getFileUrl(Request $request): string
    {
        $file = $request->file('file');

        return Storage::putFileAs(
            "spreadsheets/products/update_costs",
            $file,
            $file->getClientOriginalName());
    }

    private function successfulMessage(): string
    {
        return 'A planilha foi enviada com sucesso para ser processada. Em breve você receberá um email informando o resultado dessa operação.';
    }
}
