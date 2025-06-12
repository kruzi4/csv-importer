<?php

namespace App\Services;

use App\Contracts\ImporterInterface;
use App\DTOs\ProductDTO;
use App\Parsers\ProductCsvParser;
use App\Repositories\ProductRepository;
use App\Rules\ProductImportRule;
use Throwable;

class ProductImporterService implements ImporterInterface
{
    public function __construct(
        protected ProductCsvParser $parser,
        protected ProductRepository $repository,
    ) {}

    public function import(string $path, bool $testMode = false): array
    {
        $rows = $this->parser->parse($path);

        $processed = 0;
        $success = 0;
        $skipped = 0;
        $skippedProducts = [];
        $failures = [];

        foreach ($rows as $row) {
            try {
                $dto = ProductDTO::fromRow($row);

                if (!ProductImportRule::shouldImport($dto)) {
                    $skippedProducts[] = $row;
                    $skipped++;
                    continue;
                }

                if (!$testMode) {
                    $this->repository->save($dto);
                }

                $success++;
            } catch (Throwable $e) {
                $failures[] = [
                    'row' => $row,
                    'error' => $e->getMessage(),
                ];
                $skipped++;
            } finally {
                $processed++;
            }
        }

        return compact('processed', 'success', 'skipped', 'failures', 'skippedProducts');
    }
}
