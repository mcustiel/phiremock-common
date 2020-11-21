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

namespace Mcustiel\Phiremock\Domain\Condition;

use InvalidArgumentException;

class Pattern extends ConditionValue
{
    public function __construct(string $pattern)
    {
        $this->assertRegex($pattern);
        parent::__construct($pattern);
    }

    private function assertRegex(string $pattern): void
    {
        /**
         * The only sane way to validate a regexp is to execute it.
         * Possible warnings or notices are suppressed.
         */
        if (false === @preg_match($pattern, null)) {
            throw new InvalidArgumentException(
                sprintf('Invalid regular expression received: `%s`, preg error #%d', $pattern, preg_last_error())
            );
        }
    }
}
