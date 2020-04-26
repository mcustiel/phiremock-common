<?php

namespace Mcustiel\Phiremock\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;
use Mcustiel\Phiremock\Domain\Condition\StringValue;

class CaseInsensitiveEquals extends Matcher
{
    public function __construct(StringValue $checkValue)
    {
        parent::__construct($checkValue);
    }

    public function matches($value): bool
    {
        return strtolower($value) === strtolower($this->getCheckValue()->get());
    }

    public function getName(): string
    {
        return MatchersEnum::SAME_STRING;
    }
}
