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

namespace Mcustiel\Phiremock\Common\Utils\V1;

use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\StateConditions;

class ArrayToStateConditionsConverter
{
    public function convert(array $stateInfoArray): StateConditions
    {
        $scenarioName = null;
        if (!empty($stateInfoArray['scenarioName'])) {
            $scenarioName = new ScenarioName($stateInfoArray['scenarioName']);
        }

        $currentScenarioState = null;
        if (!empty($stateInfoArray['scenarioStateIs'])) {
            $currentScenarioState = new ScenarioState($stateInfoArray['scenarioStateIs']);
        }

        return new StateConditions($scenarioName, $currentScenarioState);
    }
}
