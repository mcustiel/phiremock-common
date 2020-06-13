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

class AbstractArrayCollection extends AbstractArrayIterator
{
    /**
     * @param int|string $key
     * @param mixed      $value
     *
     * @throws \InvalidArgumentException
     */
    protected function set($key, $value)
    {
        $this->ensureIsValidKey($key);
        $this->array[$key] = $value;
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    protected function add($value)
    {
        $this->array[] = $value;
    }

    private function ensureIsValidKey($key)
    {
        if (!\is_string($key) && !\is_int($key)) {
            throw new \InvalidArgumentException(sprintf('Key must be integer or string. Got: %s', \gettype($key)));
        }
    }
}
