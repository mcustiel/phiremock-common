<?php

namespace Mcustiel\Phiremock\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;
use Mcustiel\Phiremock\Domain\Condition\StringValue;

class Contains extends Matcher
{
    public function __construct(StringValue $checkValue)
    {
        parent::__construct($checkValue);
    }

    public function matches($value): bool
    {
        return strpos($this->getCheckValue()->get(), $value) !== false;
    }

    public function getName(): string
    {
        return MatchersEnum::CONTAINS;
    }
}
