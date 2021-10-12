<?php

namespace Src\Products\Application\Jobs\Spreadsheets;

use Src\Products\Application\Services\Costs\ImportICMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadICMS implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * To Do: passar o usuário para dentro desse método handle a fim de notificar o usuário conforme o
     * retorno do método execute.
     *
     * @param \Src\Products\Application\Services\Costs\ImportICMS $importService
     */
    public function handle(ImportICMS $importService)
    {
        $importService->execute($this->file);
    }
}
