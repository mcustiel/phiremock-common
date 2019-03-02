<?php

namespace Mcustiel\Phiremock\Domain\Options;

class ScenarioState implements \JsonSerializable
{
    const INITIAL_SCENARIO = 'Scenario.START';

    /** @var string * */
    private $state;

    /**
     * @param string $state
     */
    public function __construct($state)
    {
        $this->ensureIsValidState($state);
        $this->state = $state;
    }

    public static function createInitial()
    {
        return new self(self::INITIAL_SCENARIO);
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->state;
    }

    public function jsonSerialize()
    {
        return $this->state;
    }

    private function ensureIsValidState($state)
    {
        if (!\is_string($state)) {
            throw new \InvalidArgumentException(
                sprintf('Scenario state must be a string. Got: %s', \gettype($state))
            );
        }
    }
}
