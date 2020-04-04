<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Response;

class ResponseToArrayConverter
{
    public function convert(Response $response)
    {
        $responseArray = [
            'newScenarioState' => $response->hasNewScenarioState()
                ? $response->getNewScenarioState()->asString()
                : null,
            'delayMillis' => $response->hasDelayMillis()
                ? $response->getDelayMillis()->asInt()
                : null,
            ];

        return $responseArray;
    }
}
