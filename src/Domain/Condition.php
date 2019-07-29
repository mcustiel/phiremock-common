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

namespace Mcustiel\Phiremock\Domain;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class Condition
{
    /** @var Matcher */
    private $matcher;
    /** @var StringValue */
    private $value;

    /**
     * @param string|null $matcher
     * @param mixed       $value
     */
    public function __construct(Matcher $matcher, StringValue $value)
    {
        $this->matcher = $matcher;
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getMatcher()->asString() . ' ' . $this->getValue()->asString();
    }

    /**
     * @return Matcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @return StringValue
     */
    public function getValue()
    {
        return $this->value;
    }
}
