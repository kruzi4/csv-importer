<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\DTOs\ProductDTO;

class ProductDTOTest extends TestCase
{
    public function test_create_product_dto_with_valid_input(): void
    {
        $row = [
            'product_code' => '  ABC123  ',
            'product_name' => '  Test Product  ',
            'product_description' => '  This is a test product  ',
            'stock' => '100',
            'cost_in_gbp' => '£19.99',
            'discontinued' => '  Yes  '
        ];

        $productDTO = ProductDTO::fromRow($row);

        $this->assertEquals('ABC123', $productDTO->code);
        $this->assertEquals('Test Product', $productDTO->name);
        $this->assertEquals('This is a test product', $productDTO->description);
        $this->assertEquals(100, $productDTO->stock);
        $this->assertEquals(19.99, $productDTO->cost);
        $this->assertTrue($productDTO->discontinued);
    }

    public function test_create_product_dto_with_non_numeric_stock(): void
    {
        $row = [
            'product_code' => 'ABC123',
            'product_name' => 'Test Product',
            'product_description' => 'This is a test product',
            'stock' => 'Not a number',
            'cost_in_gbp' => '£19.99',
            'discontinued' => 'No'
        ];

        $productDTO = ProductDTO::fromRow($row);

        $this->assertEquals(0, $productDTO->stock);
    }

    public function test_create_product_dto_with_non_numeric_cost(): void
    {
        $row = [
            'product_code' => 'ABC123',
            'product_name' => 'Test Product',
            'product_description' => 'This is a test product',
            'stock' => '100',
            'cost_in_gbp' => '£19.99',
            'discontinued' => 'No'
        ];

        $productDTO = ProductDTO::fromRow($row);

        $this->assertEquals(19.99, $productDTO->cost);
    }
}
