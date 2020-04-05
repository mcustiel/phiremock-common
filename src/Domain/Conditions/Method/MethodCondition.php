<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Method;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Http\Method;

class MethodCondition extends Condition
{
    public function __construct(MethodMatcher $matcher, Method $value)
    {
        parent::__construct($matcher, $value);
    }

    public function __toString()
    {
        $value = $this->getValue()->asString();

        return sprintf(
            '%s => BINARY CONTENTS (%s bytes)',
            $this->getMatcher()->asString(),
            \strlen($value)
        );
    }
}
