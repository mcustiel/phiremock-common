<?php

namespace Mcustiel\Phiremock\Common\Utils\V1;

use Mcustiel\Phiremock\Common\Utils\ScenarioStateInfoToArrayConverter as ScenarioStateInfoToArrayConverterInterface;
use Mcustiel\Phiremock\Domain\ScenarioStateInfo;

class ScenarioStateInfoToArrayConverter implements ScenarioStateInfoToArrayConverterInterface
{
    public function convert(ScenarioStateInfo $scenarioStateInfo): array
    {
        return [
            'scenarioName'  => $scenarioStateInfo->getScenarioName()->asString(),
            'scenarioState' => $scenarioStateInfo->getScenarioState()->asString(),
        ];
    }
}
