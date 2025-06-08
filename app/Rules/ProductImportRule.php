<?php

namespace App\Rules;

use App\DTOs\ProductDTO;

class ProductImportRule
{
    public static function shouldImport(ProductDTO $product): bool
    {
        if ($product->cost < 5 && $product->stock < 10) return false;
        if ($product->cost > 1000) return false;
        return true;
    }
}
