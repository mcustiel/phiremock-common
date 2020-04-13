<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Matchers;

use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions\Pattern;

class RegExp extends Matcher
{
    public function __construct(Pattern $checkValue)
    {
        parent::__construct($checkValue);
    }

    public function matches(string $value): bool
    {
        return (bool) preg_match($value, $this->getCheckValue()->get());
    }

    public function getName(): string
    {
        return MatchersEnum::MATCHES;
    }
}
