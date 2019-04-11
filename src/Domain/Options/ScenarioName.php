<?php

namespace Mcustiel\Phiremock\Domain\Options;

class ScenarioName
{
    /** @var string * */
    private $name;

    /** @param string $name */
    public function __construct($name)
    {
        $this->ensureIsValidScenarioName($name);
        $this->name = $name;
    }

    /** @return string */
    public function asString()
    {
        return $this->name;
    }

    private function ensureIsValidScenarioName($name)
    {
        if (!\is_string($name)) {
            throw new \InvalidArgumentException(
                sprintf('Scenario name must be a string. Got: %s', \gettype($name))
            );
        }
    }
}
