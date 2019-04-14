<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

abstract class ArrayToResponseConverter
{
    const NO_DELAY = 0;

    public function convert(array $responseArray)
    {
        return $this->convertResponse(
            $responseArray,
            $this->getDelay($responseArray),
            $this->getNewScenarioState($responseArray)
        );
    }

    abstract protected function convertResponse(
        array $response,
        Delay $delay,
        ScenarioState $newScenarioState = null
    );

    /** @return \Mcustiel\Phiremock\Domain\Options\Delay */
    private function getDelay(array $responseArray)
    {
        if (!empty($responseArray['delayMillis'])) {
            return new Delay($responseArray['delayMillis']);
        }

        return new Delay(self::NO_DELAY);
    }

    /** @return null|\Mcustiel\Phiremock\Domain\Options\ScenarioState */
    private function getNewScenarioState(array $expectationArray)
    {
        $newScenarioState = null;
        if (!empty($expectationArray['newScenarioState'])) {
            $newScenarioState = new ScenarioState($expectationArray['newScenarioState']);
        }

        return $newScenarioState;
    }

}
