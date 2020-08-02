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

class Version
{
    /** @var string */
    private $version;

    public function __construct(string $version)
    {
        $this->ensureVersionIsCorrect($version);
        $this->version = $version;
    }

    public function asString(): string
    {
        return $this->version;
    }

    private function ensureVersionIsCorrect(string $version): void
    {
        $numeric = (int) $version;
        if ($numeric < 1 || $numeric > 2) {
            throw new \InvalidArgumentException(sprintf('Invalid version: %s', $version));
        }
    }
}
