<?php

namespace App\Console\Commands;

use App\Services\ProductImporterService;
use Illuminate\Console\Command;

class ImportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--test : Run import in test mode (does not write to DB)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ProductImporterService $importer): void
    {
        $path = storage_path('app/stock.csv');
        $isTest = $this->option('test');

        $result = $importer->import($path, $isTest);

        $this->info("Processed: {$result['processed']}");
        $this->info("Success: {$result['success']}");
        $this->info("Skipped: {$result['skipped']}");
        if (!empty($result['skippedProducts'])) {
            foreach ($result['skippedProducts'] as $product) {
                $this->warn(implode(', ', $product));
            }
        }
        $this->warn("Failed: " . count($result['failures']));

        foreach ($result['failures'] as $fail) {
            $this->error("Row: " . implode(', ', $fail['row']) . " - Error: " . $fail['error']);
        }
    }
}
