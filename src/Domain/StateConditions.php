<?php

namespace Mcustiel\Phiremock\Domain;

use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class StateConditions
{
    /** @var ScenarioName */
    private $scenarioName;

    /** @var ScenarioState */
    private $scenarioStateIs;

    public function __construct(
        ScenarioName $scenarioName = null,
        ScenarioState $currentScenarioState = null
    ) {
        $this->scenarioName = $scenarioName;
        $this->scenarioStateIs = $currentScenarioState;
    }

    /**
     * @return ScenarioName
     */
    public function getScenarioName()
    {
        return $this->scenarioName;
    }

    /**
     * @return ScenarioState|null
     */
    public function getScenarioStateIs()
    {
        return $this->scenarioStateIs;
    }
}
