<?php

namespace App\Parsers;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductCsvParser implements ToCollection, WithHeadingRow
{
    private array $data;

    public function parse(string $path): array
    {
        Excel::import($this, $path);
        return $this->data;
    }

    public function collection(Collection $collection): void
    {
        $this->data = $collection->toArray();
    }
}
