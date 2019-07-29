<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Method;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;

final class MethodMatcher extends Matcher
{
    const VALID_MATCHERS = [
        MatchersEnum::EQUAL_TO,
        MatchersEnum::MATCHES,
    ];

    public function __construct($matcherName)
    {
        parent::__construct($matcherName);
        $this->ensureIsValidMatcher($matcherName);
    }

    private function ensureIsValidMatcher($matcherName)
    {
        return \in_array($matcherName, self::VALID_MATCHERS, true);
    }
}
