<?php

namespace Tests\Unit;

use App\Console\Commands\ImportProductsCommand;
use App\Services\ProductImporterService;
use Tests\TestCase;
use Mockery;

class ImportProductsCommandTest extends TestCase
{
    protected $command;
    protected $importerMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->importerMock = Mockery::mock(ProductImporterService::class);
        $this->command = new ImportProductsCommand();
        $this->command->setLaravel(app());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_should_successfully_import_products_when_given_valid_csv_file(): void
    {
        $mockImporter = Mockery::mock(ProductImporterService::class);
        $this->app->instance(ProductImporterService::class, $mockImporter);

        $mockResult = [
            'processed' => 10,
            'success' => 8,
            'skipped' => 1,
            'skippedProducts' => [['Product A', 'SKU001']],
            'failures' => [
                ['row' => ['Product B', 'SKU002'], 'error' => 'Invalid data']
            ]
        ];

        $mockImporter->shouldReceive('import')
            ->once()
            ->with(storage_path('app/stock.csv'), false)
            ->andReturn($mockResult);

        $this->artisan('products:import')
            ->expectsOutput('Processed: 10')
            ->expectsOutput('Success: 8')
            ->expectsOutput('Skipped: 1')
            ->expectsOutput('Product A, SKU001')
            ->expectsOutput('Failed: 1')
            ->expectsOutput('Row: Product B, SKU002 - Error: Invalid data')
            ->assertExitCode(0);
    }

    public function test_command_runs_in_test_mode_when_test_option_is_used(): void
    {
        $this->importerMock->shouldReceive('import')
            ->once()
            ->with(storage_path('app/stock.csv'), true)
            ->andReturn([
                'processed' => 10,
                'success' => 8,
                'skipped' => 1,
                'skippedProducts' => [['Product A', 'SKU001']],
                'failures' => [['row' => ['Product B', 'SKU002'], 'error' => 'Invalid data']]
            ]);

        $this->app->instance(ProductImporterService::class, $this->importerMock);

        $this->artisan('products:import', ['--test' => true])
            ->expectsOutput('Processed: 10')
            ->expectsOutput('Success: 8')
            ->expectsOutput('Skipped: 1')
            ->expectsOutput('Product A, SKU001')
            ->expectsOutput('Failed: 1')
            ->expectsOutput('Row: Product B, SKU002 - Error: Invalid data')
            ->assertExitCode(0);
    }

    public function test_should_validate_product_data_and_skip_invalid_entries(): void
    {
        $mockImporter = Mockery::mock(ProductImporterService::class);
        $this->app->instance(ProductImporterService::class, $mockImporter);

        $mockResult = [
            'processed' => 5,
            'success' => 3,
            'skipped' => 1,
            'skippedProducts' => [['Invalid Product', 'SKU123']],
            'failures' => [
                ['row' => ['Faulty Product', 'SKU456'], 'error' => 'Missing required field']
            ]
        ];

        $mockImporter->shouldReceive('import')
            ->once()
            ->with(storage_path('app/stock.csv'), false)
            ->andReturn($mockResult);

        $this->artisan('products:import')
            ->expectsOutput('Processed: 5')
            ->expectsOutput('Success: 3')
            ->expectsOutput('Skipped: 1')
            ->expectsOutput('Invalid Product, SKU123')
            ->expectsOutput('Failed: 1')
            ->expectsOutput('Row: Faulty Product, SKU456 - Error: Missing required field')
            ->assertExitCode(0);
    }
}
