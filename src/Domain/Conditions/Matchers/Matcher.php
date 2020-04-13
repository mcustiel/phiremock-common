<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Matchers;

use Mcustiel\Phiremock\Domain\Conditions\ConditionValue;

abstract class Matcher
{
    /** @var ConditionValue */
    private $checkValue;

    public function __construct(ConditionValue $checkValue)
    {
        $this->checkValue = $checkValue;
    }

    public function getCheckValue(): ConditionValue
    {
        return (string) $this->checkValue;
    }

    abstract public function getName(): string;

    abstract public function matches($value): bool;
}
