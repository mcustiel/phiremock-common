<?php

namespace Mcustiel\Phiremock\Domain;

use Mcustiel\Phiremock\Domain\Options\ScenarioState;

abstract class Response
{
    /** @var ScenarioState */
    private $newScenarioState;

    public function __construct(ScenarioState $newScenarioState = null)
    {
        $this->newScenarioState = $newScenarioState;
    }

    public function getNewScenarioState()
    {
        return $this->newScenarioState;
    }

    public function isHttpResponse()
    {
        return false;
    }

    public function isProxyResponse()
    {
        return false;
    }
}
