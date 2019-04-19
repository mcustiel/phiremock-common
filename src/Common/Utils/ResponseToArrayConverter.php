<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Response;

class ResponseToArrayConverter
{
    public function convert(Response $response)
    {
        $responseArray = [];
        if ($response->hasNewScenarioState()) {
            $responseArray['newScenarioState'] = $response->getNewScenarioState()->asString();
        }
        if ($response->hasDelayMillis()) {
            $responseArray['delayMillis'] = $response->getDelayMillis()->asInt();
        }

        return $responseArray;
    }
}
