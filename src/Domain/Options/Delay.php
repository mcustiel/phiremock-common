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

class Delay
{
    /** @var int * */
    private $delay;

    /** @param int $delay */
    public function __construct($delay)
    {
        $this->ensureIsValidDelay($delay);
        $this->delay = $delay;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\Delay */
    public static function createDefault()
    {
        return new self(0);
    }

    /** @return int */
    public function asInt()
    {
        return $this->delay;
    }

    private function ensureIsValidDelay($delay)
    {
        if (!\is_int($delay)) {
            throw new \InvalidArgumentException(sprintf('Delay must be an integer. Got: %s', \gettype($delay)));
        }
        if ($delay < 0) {
            throw new \InvalidArgumentException(sprintf('Delay must be greater or equal to 0. Got: %d', $delay));
        }
    }
}
