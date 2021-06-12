<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductICMSImport implements ToCollection
{
    use Importable;

    private array $products = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if (0 === $index) {
                continue;
            }
            $this->products[] = [
                'sku' => $row[1],
                'icms' => $row[34],
            ];
        }

        return $this->products;
    }

    public function get()
    {
        return $this->products;
    }
}
