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
