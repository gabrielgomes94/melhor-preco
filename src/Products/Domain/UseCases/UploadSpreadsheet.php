<?php

namespace Src\Products\Domain\UseCases;

// @deprecated
interface UploadSpreadsheet
{
    public function upload(string $filePath, ?string $userId = null): void;
}
