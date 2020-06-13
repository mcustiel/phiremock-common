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
                return self::contains($value);
            case MatchersEnum::EQUAL_TO:
                return self::equalsTo($value);
            case MatchersEnum::MATCHES:
                return self::matches($value);
            case MatchersEnum::SAME_JSON:
                return self::jsonEquals($value);
            case MatchersEnum::SAME_STRING:
                return self::sameString($value);
        }
        throw new \InvalidArgumentException('Invalid condition matcher specified: ' . $identifier);
    }

    public static function contains($value): Contains
    {
        return new Contains(new StringValue($value));
    }

    public static function equalsTo($value): Equals
    {
        return new Equals(new ConditionValue($value));
    }

    public static function matches($value): RegExp
    {
        return new RegExp(new Pattern($value));
    }

    public static function jsonEquals($value): JsonEquals
    {
        return new JsonEquals(new Json($value));
    }

    public static function sameString($value): CaseInsensitiveEquals
    {
        return new CaseInsensitiveEquals(new StringValue($value));
    }
}
