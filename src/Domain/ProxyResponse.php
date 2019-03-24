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

use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ProxyResponse extends Response
{
    /** @var Uri */
    private $uri;

    public function __construct(Uri $uri, ScenarioState $newScenarioState)
    {
        parent::__construct($newScenarioState);
        $this->uri = $uri;
    }

    public function __toString()
    {
        return $this->uri->asString();
    }

    /**
     * @return Uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    public function isProxyResponse()
    {
        return true;
    }
}
