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

namespace Mcustiel\Phiremock\Domain\Options;

class Priority
{
    /** @var int * */
    private $priority;

    /** @param int $priority */
    public function __construct($priority)
    {
        $this->ensureIsValidPriority($priority);
        $this->priority = $priority;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\Priority */
    public static function createDefault()
    {
        return new self(0);
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->priority;
    }

    /** @return string */
    public function asString()
    {
        return sprintf('%d', $this->priority);
    }

    private function ensureIsValidPriority($priority)
    {
        if (!\is_int($priority)) {
            throw new \InvalidArgumentException(sprintf('Priority must be an integer. Got: %s', \gettype($priority)));
        }
        if ($priority < 0) {
            throw new \InvalidArgumentException(sprintf('Priority must be greater or equal to 0. Got: %d', $priority));
        }
    }
}
