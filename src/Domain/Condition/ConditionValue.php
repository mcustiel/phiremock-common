<?php

namespace Mcustiel\Phiremock\Domain\Condition;

class ConditionValue
{
    /** @var mixed */
    private $value;

    /** @param mixed $value */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function asString(): string
    {
        return (string) $this->value;
    }

    public function get()
    {
        return $this->value;
    }
}
