<?php

namespace Mcustiel\Phiremock\Domain\Options;

class Delay
{
    /** @var int * */
    private $delay;

    /** @param int $delay */
    public function __construct($delay)
    {
        $this->ensureIsValidDelay($delay);
        $this->delay = $delay;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\Delay */
    public static function createDefault()
    {
        return new self(0);
    }

    /** @return int */
    public function asInt()
    {
        return $this->delay;
    }

    private function ensureIsValidDelay($delay)
    {
        if (!\is_int($delay)) {
            throw new \InvalidArgumentException(sprintf('Delay must be an integer. Got: %s', \gettype($delay)));
        }
        if ($delay < 0) {
            throw new \InvalidArgumentException(sprintf('Delay must be greater or equal to 0. Got: %d', $delay));
        }
    }
}
