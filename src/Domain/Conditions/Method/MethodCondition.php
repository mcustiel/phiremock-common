<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Method;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\Matchers\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;

class MethodCondition extends Condition
{
    private const VALID_MATCHERS = [
        MatchersEnum::SAME_STRING,
        MatchersEnum::MATCHES,
    ];

    public function __construct(Matcher $matcher)
    {
        $this->ensureIsValidMatcher($matcher->getName());
        parent::__construct($matcher);
    }

    public function __toString()
    {
        $value = $this->getValue()->asString();

        return sprintf(
            '%s => BINARY CONTENTS (%s bytes)',
            $this->getMatcher()->getName(),
            \strlen($value)
        );
    }

    private function ensureIsValidMatcher(string $matcherName): void
    {
        if (!\in_array($matcherName, self::VALID_MATCHERS, true)) {
            throw new \InvalidArgumentException(sprintf('%s is not an allowed condition matcher for http methods.', $matcherName));
        }
    }
}
