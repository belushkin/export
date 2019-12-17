<?php

namespace App\Service\Export;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * CSV ExportMessage class.
 */
class CSV extends ExportAbstract implements ExportInterface
{

    /**
     * @var String
     */
    protected $type = 'csv';

    public function export(array $data): void
    {
        $this->openFile();

        array_unshift($data, array_keys(reset($data)));

        foreach($data as $row) {
            fputcsv($this->handle, $this->applyConstraints($row));
        }

        $this->closeFile();
    }

}
