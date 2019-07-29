<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class HeaderCondition extends Condition
{
    public function __construct(Matcher $matcher, StringValue $headerValue)
    {
        parent::__construct($matcher, $headerValue);
    }

    public static function fromCondition(Condition $condition)
    {
        return new self($condition->getMatcher(), new StringValue($condition->getValue()));
    }
}
