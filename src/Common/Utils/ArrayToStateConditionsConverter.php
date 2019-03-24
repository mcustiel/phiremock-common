<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\StateConditions;

class ArrayToStateConditionsConverter
{
    public function convert(array $stateInfoArray)
    {
        $scenarioName = null;
        if (!empty($stateInfoArray['scenarioName'])) {
            $scenarioName = new ScenarioName($stateInfoArray['scenarioName']);
        }

        $currentScenarioState = null;
        if (!empty($stateInfoArray['scenarioStateIs'])) {
            $currentScenarioState = new ScenarioState($stateInfoArray['body']);
        }

        return new StateConditions($scenarioName, $currentScenarioState);
    }
}
