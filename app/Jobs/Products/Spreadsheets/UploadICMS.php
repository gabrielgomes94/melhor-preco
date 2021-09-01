<?php

namespace App\Jobs\Products\Spreadsheets;

use App\Services\Product\ImportICMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadICMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function handle(ImportICMS $importService)
    {
        $importService->execute($this->file);
    }
}
