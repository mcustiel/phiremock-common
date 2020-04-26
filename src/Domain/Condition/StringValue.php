<?php

namespace Mcustiel\Phiremock\Domain\Condition;

class StringValue extends ConditionValue
{
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}
