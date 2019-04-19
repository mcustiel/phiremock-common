<?php

namespace Mcustiel\Phiremock\Domain;

use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

abstract class Response
{
    /** @var ScenarioState */
    private $newScenarioState;
    /** @var Delay */
    private $delayMillis;

    public function __construct(
        Delay $delayMillis = null,
        ScenarioState $newScenarioState = null
    ) {
        $this->newScenarioState = $newScenarioState;
        $this->delayMillis = $delayMillis;
    }

    /** @return bool */
    public function hasNewScenarioState()
    {
        return null !== $this->newScenarioState;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\ScenarioState */
    public function getNewScenarioState()
    {
        return $this->newScenarioState;
    }

    /** @return bool */
    public function hasDelayMillis()
    {
        return $this->delayMillis !== null;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\Delay */
    public function getDelayMillis()
    {
        return $this->delayMillis;
    }

    /** @return bool */
    public function isHttpResponse()
    {
        return false;
    }

    /** @return bool */
    public function isProxyResponse()
    {
        return false;
    }
}
