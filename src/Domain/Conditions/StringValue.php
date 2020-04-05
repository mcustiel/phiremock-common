<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

class StringValue
{
    /** @var string */
    private $value;

    /** @param string $stringValue */
    public function __construct(string $stringValue)
    {
        $this->value = $stringValue;
    }

    public function asString(): string
    {
        return $this->value;
    }
}
