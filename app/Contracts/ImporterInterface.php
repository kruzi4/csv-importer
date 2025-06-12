<?php

namespace App\Contracts;

interface ImporterInterface
{
    public function import(string $path, bool $testMode = false): array;
}

