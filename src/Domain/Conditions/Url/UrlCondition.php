<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Url;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class UrlCondition extends Condition
{
    public function __construct(Matcher $matcher, StringValue $url)
    {
        parent::__construct($matcher, $url);
    }

    public static function fromCondition(Condition $condition)
    {
        return new self($condition->getMatcher(), new StringValue($condition->getValue()));
    }
}
