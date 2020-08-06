<?php

namespace Mcustiel\Phiremock\Common\Utils;

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
