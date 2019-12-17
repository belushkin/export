<?php

namespace App\Service\Export\Constraints;

interface ConstraintInterface
{
    public function meetCriteria(string $value);

    public function getField(): string;
}
