<?php

namespace Mcustiel\Phiremock\Domain\Options;

class Priority
{
    /** @var int * */
    private $priority;

    /** @param int $priority */
    public function __construct($priority)
    {
        $this->ensureIsValidPriority($priority);
        $this->priority = $priority;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\Priority */
    public static function createDefault()
    {
        return new self(0);
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->priority;
    }

    /** @return string */
    public function asString()
    {
        return sprintf('%d', $this->priority);
    }

    private function ensureIsValidPriority($priority)
    {
        if (!\is_int($priority)) {
            throw new \InvalidArgumentException(
                sprintf('Priority must be an integer. Got: %s', \gettype($priority))
            );
        }
        if ($priority < 0) {
            throw new \InvalidArgumentException(
                sprintf('Priority must be greater or equal to 0. Got: %d', $priority)
            );
        }
    }
}
