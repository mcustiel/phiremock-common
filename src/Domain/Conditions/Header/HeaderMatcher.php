<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;

final class HeaderMatcher extends Matcher
{
    const VALID_MATCHERS = [
        MatchersEnum::CONTAINS,
        MatchersEnum::EQUAL_TO,
        MatchersEnum::MATCHES,
        MatchersEnum::SAME_STRING,
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
