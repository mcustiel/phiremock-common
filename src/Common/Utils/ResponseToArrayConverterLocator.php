<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Factory;

class ResponseToArrayConverterLocator
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function locate(Response $response)
    {
        $responseArray = [];

        if ($response->isHttpResponse()) {
            $responseArray['delayMillis'] = $response->getDelayMillis()->asInt();
        }
        if ($response->hasNewScenarioState()) {
            $responseArray['newScenarioState'] = $response->getNewScenarioState()->asString();
        }

        return $responseArray;
    }
}
