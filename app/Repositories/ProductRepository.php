<?php

namespace App\Repositories;

use App\DTOs\ProductDTO;
use App\Models\Product;

class ProductRepository
{
    public function save(ProductDTO $dto): void
    {
        Product::updateOrCreate(
            ['strProductCode' => $dto->code],
            [
                'strProductName' => $dto->name,
                'strProductDesc' => $dto->description,
                'dtmAdded' => now(),
                'dtmDiscontinued' => $dto->discontinued ? now() : null,
                'intStock' => $dto->stock,
                'decPrice' => $dto->cost,
            ]
        );
    }
}
