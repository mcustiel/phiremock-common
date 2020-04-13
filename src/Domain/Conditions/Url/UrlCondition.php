<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Url;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\Matchers\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;

class UrlCondition extends Condition
{
    private const VALID_MATCHERS = [
        MatchersEnum::SAME_STRING,
        MatchersEnum::MATCHES,
        MatchersEnum::CONTAINS,
        MatchersEnum::EQUAL_TO,
    ];

    public function __construct(Matcher $matcher)
    {
        $this->ensureIsValidMatcher($matcher->getName());
        parent::__construct($matcher);
    }

    private function ensureIsValidMatcher(string $matcherName): void
    {
        if (!\in_array($matcherName, self::VALID_MATCHERS, true)) {
            throw new \InvalidArgumentException(sprintf('%s is not an allowed condition matcher for urls.', $matcherName));
        }
    }
}
