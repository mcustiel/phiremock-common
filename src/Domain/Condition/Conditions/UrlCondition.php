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

namespace Mcustiel\Phiremock\Domain\Condition\Conditions;

use Mcustiel\Phiremock\Domain\Condition\Condition;
use Mcustiel\Phiremock\Domain\Condition\Matchers\Matcher;
use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;

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
