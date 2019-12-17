<?php

namespace App\Message;

use App\Service\Export\Constraints\ConstraintInterface;

class ExportMessage
{
    private $type;

    private $constraints;

    private $email;

    public function getType()
    {
        return $this->type;
    }

    public function addConstraint(ConstraintInterface $constraint)
    {
        $this->constraints[] = $constraint;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function addEmail(string $email)
    {
        $this->email = $email;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

}
