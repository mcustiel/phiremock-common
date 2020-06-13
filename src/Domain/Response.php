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

use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class Response
{
    /** @var ScenarioState */
    private $newScenarioState;
    /** @var Delay */
    private $delayMillis;

    public function __construct(
        ?Delay $delayMillis = null,
        ?ScenarioState $newScenarioState = null
    ) {
        $this->newScenarioState = $newScenarioState;
        $this->delayMillis = $delayMillis;
    }

    /** @return self */
    public static function createEmpty()
    {
        return new self();
    }

    /** @return bool */
    public function hasNewScenarioState()
    {
        return null !== $this->newScenarioState;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\ScenarioState */
    public function getNewScenarioState()
    {
        return $this->newScenarioState;
    }

    /** @return bool */
    public function hasDelayMillis()
    {
        return $this->delayMillis !== null;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\Delay */
    public function getDelayMillis()
    {
        return $this->delayMillis;
    }

    /** @return bool */
    public function isHttpResponse()
    {
        return false;
    }

    /** @return bool */
    public function isProxyResponse()
    {
        return false;
    }
}
