<?php

namespace App\Service\Export\Constraints;

class LessThan extends ConstraintAbstract implements ConstraintInterface
{

    public function meetCriteria(string $value): string
    {
        return substr($value, 0, $this->limit) . '...';
    }
}
