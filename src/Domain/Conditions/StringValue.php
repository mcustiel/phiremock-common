<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

class StringValue extends ConditionValue
{
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}
