<?php

namespace Mcustiel\Phiremock\Domain\Options;

class ScenarioState
{
    const INITIAL_SCENARIO = 'Scenario.START';

    /** @var string * */
    private $state;

    public function __construct(string $state)
    {
        $this->ensureNotEmpty($state);
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

    private function ensureNotEmpty($state)
    {
        if (empty($state)) {
            throw new \InvalidArgumentException('Scenario state can not be empty');
        }
    }
}
