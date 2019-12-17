<?php

namespace App\Service\Export;

interface ExportInterface
{
    public function export(array $data): void;

    public function canExport(string $type): bool;
}
