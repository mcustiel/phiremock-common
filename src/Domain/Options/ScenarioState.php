<?php

namespace Mcustiel\Phiremock\Domain\Options;

class ScenarioState
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

    /**
     * @param ScenarioState $other
     *
     * @return bool
     */
    public function equals($other)
    {
        return $other->asString() === $this->asString();
    }

    private function ensureIsValidState($state)
    {
        if (!\is_string($state)) {
            throw new \InvalidArgumentException(sprintf('Scenario state must be a string. Got: %s', \gettype($state)));
        }
    }
}
