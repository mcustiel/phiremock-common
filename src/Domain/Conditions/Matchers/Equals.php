<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Matchers;

use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;

class Equals extends Matcher
{
    public function matches($value): bool
    {
        return $value === $this->getCheckValue()->get();
    }

    public function getName(): string
    {
        return MatchersEnum::EQUAL_TO;
    }
}
