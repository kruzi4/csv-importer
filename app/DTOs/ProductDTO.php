<?php

namespace App\DTOs;
class ProductDTO
{
    public function __construct(
        public string $code,
        public string $name,
        public string $description,
        public int $stock,
        public float $cost,
        public bool $discontinued
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            code: trim($row['product_code'] ?? ''),
            name: trim($row['product_name'] ?? ''),
            description: trim($row['product_description'] ?? ''),
            stock: is_numeric($row['stock']) ? (int)$row['stock'] : 0,
            cost: (float) preg_replace('/[^\d.]/', '', $row['cost_in_gbp'] ?? '0'),
            discontinued: strtolower(trim($row['discontinued'] ?? '')) === 'yes'
        );
    }
}
