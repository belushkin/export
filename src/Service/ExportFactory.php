<?php

namespace App\Service;

use App\Service\Export\CSV;
use App\Service\Export\XML;

class ExportFactory
{
    private $engines = [];

    public function __construct(CSV $csv, XML $xml)
    {
        $this->engines[] = $csv;
        $this->engines[] = $xml;
    }

    public function createExportEngine(string $type)
    {
        foreach ($this->engines as $engine) {
            if ($engine->canExport($type)) {
                return $engine;
            }
        }

        return current($this->engines);
    }
}
