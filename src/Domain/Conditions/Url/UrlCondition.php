<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Url;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class UrlCondition extends Condition
{
    public function __construct(UrlMatcher $matcher, StringValue $value)
    {
        parent::__construct($matcher, $value);
    }
}
