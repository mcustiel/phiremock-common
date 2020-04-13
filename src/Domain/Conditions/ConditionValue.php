<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

class ConditionValue
{
    /** @var mixed */
    private $value;

    /** @param mixed $stringValue */
    public function __construct($stringValue)
    {
        $this->value = $stringValue;
    }

    public function asString(): string
    {
        return (string) $this->value;
    }

//     public function __toString(): string
//     {
//         return (string) $this->value;
//     }

    public function get()
    {
        return $this->value;
    }
}
