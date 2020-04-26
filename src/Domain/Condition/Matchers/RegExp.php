<?php

namespace Mcustiel\Phiremock\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;
use Mcustiel\Phiremock\Domain\Condition\Pattern;

class RegExp extends Matcher
{
    public function __construct(Pattern $checkValue)
    {
        parent::__construct($checkValue);
    }

    public function matches($value): bool
    {
        return preg_match($this->getCheckValue()->get(), $value) !== 0;
    }

    public function getName(): string
    {
        return MatchersEnum::MATCHES;
    }
}
