<?php

namespace App\Service\Export;

use App\Entity\Job;
use App\Service\Export\Constraints\ConstraintInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class ExportAbstract
{

    /**
     * @var String
     */
    protected $type;

    /**
     * @var ParameterBagInterface
     */
    protected $params;

    /**
     * @var String
     */
    protected $path;

    /**
     * @var ConstraintInterface[]
     */
    protected $constraints = [];

    protected $handle = null;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params       = $params;
        $this->path         = $this->params->get('export_path') . $this->params->get($this->type);
    }

    public function setConstraints(array $constraints = null): void
    {
        $this->constraints = $constraints;
    }

    public function __destruct()
    {
        $this->closeFile();
    }

    public function canExport(string $type): bool
    {
        return $this->type == strtolower($type);
    }

    protected function openFile($mode = 'w'): void
    {
        if (!$this->handle) {
            $this->handle = fopen($this->path, $mode);
            if ($this->handle === false) {
                throw new \Exception(['Can not open export file.', 'file' => $this->path, 'mode' => $mode]);
            }
        }
    }

    protected function closeFile(): void
    {
        if ($this->handle) {
            fclose($this->handle);
            $this->handle = null;
        }
    }

    protected function applyConstraint($name, $value)
    {
        if ($this->constraints) {
            foreach ($this->constraints as $constraint) {
                if ($constraint->getField() == $name) {
                    $value = $constraint->meetCriteria($value);
                }
            }
        }
        return $value;
    }

    protected function applyConstraints(array $row): array
    {
        if ($this->constraints) {
            foreach ($this->constraints as $constraint) {
                if (isset($row[$constraint->getField()])) {
                    $row[$constraint->getField()] = $constraint->meetCriteria($row[$constraint->getField()]);
                }
            }
        }
        return $row;
    }

}
