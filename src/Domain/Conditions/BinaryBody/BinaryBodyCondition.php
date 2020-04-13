<?php

namespace Mcustiel\Phiremock\Domain\Conditions\BinaryBody;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\Matchers\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;

class BinaryBodyCondition extends Condition
{
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
            $this->getMatcher()->asString(),
            \strlen($value)
        );
    }

    private function ensureIsValidMatcher(string $matcherName): void
    {
        if ($matcherName !== MatchersEnum::EQUAL_TO) {
            throw new \InvalidArgumentException(sprintf('%s is not an allowed condition matcher for Binary Body.', $matcherName));
        }
    }
}
