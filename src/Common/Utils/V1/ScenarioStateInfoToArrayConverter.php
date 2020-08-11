<?php

namespace Mcustiel\Phiremock\Common\Utils\V1;

use Mcustiel\Phiremock\Domain\ScenarioStateInfo;

class ScenarioStateInfoToArrayConverter
{
    public function convert(ScenarioStateInfo $scenarioStateInfo): array
    {
        return [
            'scenarioName'  => $scenarioStateInfo->getScenarioName()->asString(),
            'scenarioState' => $scenarioStateInfo->getScenarioState()->asString(),
        ];
    }
}
