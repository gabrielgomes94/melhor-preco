<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface UploadSpreadsheet
{
    public function upload(string $filePath, ?string $userId = null): void;
}
