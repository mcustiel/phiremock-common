<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class HeaderCondition extends Condition
{
    public function __construct(HeaderMatcher $matcher, StringValue $value)
    {
        parent::__construct($matcher, $value);
    }
}
