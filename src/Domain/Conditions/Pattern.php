==== BASE ====
<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

use InvalidArgumentException;

class Pattern extends ConditionValue
{
    public function __construct(string $pattern)
    {
        $this->assertRegex($pattern);
        parent::__construct($pattern);
    }

    private function assertRegex(string $pattern): void
    {
        if ($pattern[0] !== $pattern[\strlen($pattern) - 1]) {
            throw new InvalidArgumentException(sprintf('Invalid regular expression received: %s', $pattern));
        }
    }
}
