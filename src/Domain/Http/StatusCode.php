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

namespace Mcustiel\Phiremock\Domain\Http;

class StatusCode
{
    /** @var int * */
    private $statusCode;

    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        $this->ensureIsValidStatusCode($statusCode);
        $this->statusCode = $statusCode;
    }

    public static function createDefault()
    {
        return new self(200);
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->statusCode;
    }

    /**
     * @param StatusCode $other
     *
     * @return bool
     */
    public function equals($other)
    {
        return $this->asInt() === $other->asInt();
    }

    private function ensureIsValidStatusCode($statusCode)
    {
        if (!\is_int($statusCode)) {
            throw new \InvalidArgumentException(sprintf('Status code must be an integer. Got: %s', \gettype($statusCode)));
        }
        if ($statusCode < 100 || $statusCode >= 600) {
            throw new \InvalidArgumentException(sprintf('Invalid status code: %d', $statusCode));
        }
    }
}
