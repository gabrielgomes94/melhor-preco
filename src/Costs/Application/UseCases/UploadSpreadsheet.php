<?php

namespace Src\Products\Application\UseCases;

use App\Models\User;
use Src\Notifications\Domain\Notifications\Products\ProductsICMSWasUpdated;
use Src\Products\Application\Jobs\Spreadsheets\UploadICMS;
use Src\Products\Domain\UseCases\UploadSpreadsheet as UploadSpreadsheetInterface;

// @deprecated
class UploadSpreadsheet implements UploadSpreadsheetInterface
{
    public function upload(string $filePath, ?string $userId = null): void
    {
        UploadICMS::dispatch($filePath);

        if (!$userId) {
            return;
        }

        User::find($userId)->notify(new ProductsICMSWasUpdated());
    }
}
