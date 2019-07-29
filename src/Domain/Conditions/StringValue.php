<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

use InvalidArgumentException;

class StringValue
{
    /** @var string */
    private $value;

    /** @param string $stringValue */
    public function __construct($stringValue)
    {
        $this->assertString($stringValue);
        $this->value = $stringValue;
    }

    /** @return string */
    public function asString()
    {
        return $this->value;
    }

    /**
     * @param string $pattern
     *
     * @throws InvalidArgumentException
     */
    private function assertString($pattern)
    {
        if (!\is_string($pattern)) {
            throw new InvalidArgumentException(
                sprintf('Expected string got: %s', \gettype($pattern))
            );
        }
    }
}
