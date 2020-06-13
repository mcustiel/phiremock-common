<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */

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
