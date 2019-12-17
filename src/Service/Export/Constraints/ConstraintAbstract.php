<?php

namespace App\Service\Export\Constraints;

abstract class ConstraintAbstract
{

    protected $field = 'field';

    protected $limit;

    public function __construct(string $field, int $limit = 100)
    {
        $this->field = $field;
        $this->limit = $limit;
    }

    public function getField(): string
    {
        return $this->field;
    }

}
