<?php

namespace Tests\Unit;

use App\DTOs\ProductDTO;
use App\Rules\ProductImportRule;
use PHPUnit\Framework\TestCase;

class ProductImportRuleTest extends TestCase
{
    public function test_should_return_false_when_cost_less_than_5_and_stock_less_than_10(): void
    {
        $product = new ProductDTO(
            code: 'TEST001',
            name: 'Test Product',
            description: 'Test Description',
            stock: 9,
            cost: 4,
            discontinued: false
        );

        $result = ProductImportRule::shouldImport($product);

        $this->assertFalse($result);
    }

    public function test_should_return_false_when_cost_is_greater_than_1000(): void
    {
        $product = new ProductDTO(
            code: 'TEST002',
            name: 'Expensive Product',
            description: 'Expensive Description',
            stock: 100,
            cost: 1001,
            discontinued: false
        );

        $result = ProductImportRule::shouldImport($product);

        $this->assertFalse($result);
    }
}
