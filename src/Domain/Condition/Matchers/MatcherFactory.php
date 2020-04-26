<?php

namespace Mcustiel\Phiremock\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Domain\Condition\ConditionValue;
use Mcustiel\Phiremock\Domain\Condition\Json;
use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;
use Mcustiel\Phiremock\Domain\Condition\Pattern;
use Mcustiel\Phiremock\Domain\Condition\StringValue;

class MatcherFactory
{
    public function createFrom(string $identifier, $value): Matcher
    {
        switch ($identifier) {
            case MatchersEnum::CONTAINS:
                return new Contains(new StringValue($value));
            case MatchersEnum::EQUAL_TO:
                return new Equals(new ConditionValue($value));
            case MatchersEnum::MATCHES:
                return new RegExp(new Pattern($value));
            case MatchersEnum::SAME_JSON:
                return new JsonEquals(new Json($value));
            case MatchersEnum::SAME_STRING:
                return new CaseInsensitiveEquals(new StringValue($value));
        }
        throw new \InvalidArgumentException('Invalid condition matcher specified: ' . $identifier);
    }
}
