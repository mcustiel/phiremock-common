<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\ScenarioStateInfo;

class ArrayToScenarioStateInfoConverter
{
    /**
     * @param array $expectationArray
     *
     * @return ScenarioStateInfo
     */
    public function convert(array $expectationArray)
    {
        if (empty($expectationArray['scenarioName'])) {
            throw new \InvalidArgumentException('Scenario name not set');
        }

        if (empty($expectationArray['scenarioState'])) {
            throw new \InvalidArgumentException('Scenario state not set');
        }

        return new ScenarioStateInfo(
            new ScenarioName($expectationArray['scenarioName']),
            new ScenarioState($expectationArray['scenarioState'])
        );
    }
}
