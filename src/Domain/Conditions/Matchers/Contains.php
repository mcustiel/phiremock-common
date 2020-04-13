<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Matchers;

use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class Contains extends Matcher
{
    public function __construct(StringValue $checkValue)
    {
        parent::__construct($checkValue);
    }

    public function matches(string $value): bool
    {
        return strpos($this->getCheckValue()->get(), $value) !== false;
    }

    public function getName(): string
    {
        return MatchersEnum::CONTAINS;
    }
}
