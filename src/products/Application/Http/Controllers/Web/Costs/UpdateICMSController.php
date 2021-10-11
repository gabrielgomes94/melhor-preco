<?php

namespace Src\Products\Application\Http\Controllers\Web\Costs;

use App\Http\Controllers\Controller;
use Src\Products\Application\Jobs\Spreadsheets\UploadICMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Src\Notifications\Domain\Notifications\Products\ProductsICMSWasUpdated;

use function view;

class UpdateICMSController extends Controller
{
    public function updateICMS()
    {
        return view('pages.products.costs.upload_icms');
    }

    /**
     * To Do: criar form request na camada de aplicação após refatorar os códigos de produtos. sssssss
     */
    public function doUpdateICMS(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt,xlsx',
            ]);

            UploadICMS::dispatch($this->getFileUrl($request));
            session()->flash('message', $this->successfulMessage());
            $request->user()->notify(new ProductsICMSWasUpdated());
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
            $file->getClientOriginalName()
        );
    }

    private function successfulMessage(): string
    {
        return 'A planilha foi enviada com sucesso para ser processada. Em breve você receberá um email informando o resultado dessa operação.';
    }
}
