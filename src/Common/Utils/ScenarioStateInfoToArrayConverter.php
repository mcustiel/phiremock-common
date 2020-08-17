<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\ScenarioStateInfo;

interface ScenarioStateInfoToArrayConverter
{
    public function convert(ScenarioStateInfo $scenarioStateInfo): array;
}
