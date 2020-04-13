<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Response;

abstract class ArrayToResponseConverter
{
    const NO_DELAY = 0;

    public function convert(array $responseArray): Response
    {
        return $this->convertResponse(
            $responseArray,
            $this->getDelay($responseArray),
            $this->getNewScenarioState($responseArray)
        );
    }

    abstract protected function convertResponse(
        array $response,
        ?Delay $delay,
        ?ScenarioState $newScenarioState
    ): Response;

    private function getDelay(array $responseArray): ?Delay
    {
        if (empty($responseArray['response'])) {
            return null;
        }

        $responseArray = $responseArray['response'];
        if (!empty($responseArray['delayMillis'])) {
            return new Delay($responseArray['delayMillis']);
        }

        return null;
    }

    private function getNewScenarioState(array $expectationArray): ?ScenarioState
    {
        $newScenarioState = null;
        if (!empty($expectationArray['newScenarioState'])) {
            $newScenarioState = new ScenarioState($expectationArray['newScenarioState']);
        }

        return $newScenarioState;
    }
}
