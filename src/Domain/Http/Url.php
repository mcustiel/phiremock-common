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

class Url
{
    const URL_PATH_REGEX = '~^/(?:[^/?#]*)?(?:[^?#]*)(?:\?(?:[^#]*))?~';

    /** @var string * */
    private $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->ensureIsValidUrl($url);
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->url;
    }

    /**
     * @param Url $other
     *
     * @return bool
     */
    public function equals($other)
    {
        return $this->asString() === $other->asString();
    }

    private function ensureIsValidUrl($url)
    {
        if (!\is_string($url)) {
            throw new \InvalidArgumentException(sprintf('Url must be a string. Got: %s', \gettype($url)));
        }

        if (!preg_match(self::URL_PATH_REGEX, $url)) {
            throw new \InvalidArgumentException(sprintf('Invalid http url: %s', var_export($url, true)));
        }
    }
}
