<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

use InvalidArgumentException;

class Pattern extends StringValue
{
    /** @param string $pattern */
    public function __construct($pattern)
    {
        parent::__construct($pattern);
        $this->assertRegex($pattern);
    }

    /**
     * @param string $pattern
     *
     * @throws InvalidArgumentException
     */
    private function assertRegex($pattern)
    {
        if ($pattern[0] !== $pattern[\strlen($pattern) - 1]) {
            throw new InvalidArgumentException(
                sprintf('Invalid regular expression received: %s', $pattern)
            );
        }
    }
}
