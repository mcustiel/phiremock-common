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

use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ScenarioStateInfo
{
    /** @var ScenarioName */
    private $scenarioName;

    /** @var ScenarioState */
    private $scenarioState;

    /**
     * @param string $name
     * @param string $state
     */
    public function __construct(ScenarioName $name = null, ScenarioState $state = null)
    {
        if (null === $name) {
            $this->scenarioName = new ScenarioName();
        }
        if (null === $state) {
            $this->scenarioState = new ScenarioState();
        }
    }

    /**
     * @return ScenarioName
     */
    public function getScenarioName()
    {
        return $this->scenarioName;
    }

    /**
     * @param ScenarioName $scenario
     *
     * @return self
     */
    public function setScenarioName(ScenarioName $scenario)
    {
        $this->scenarioName = $scenario;

        return $this;
    }

    /**
     * @return ScenarioState
     */
    public function getScenarioState()
    {
        return $this->scenarioState;
    }

    /**
     * @param ScenarioState $scenarioState
     *
     * @return self
     */
    public function setScenarioState(ScenarioState $scenarioState)
    {
        $this->scenarioState = $scenarioState;

        return $this;
    }
}
