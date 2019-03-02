<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Http\Url;

class UrlCondition extends Condition
{
    public function __construct(Matcher $matcher, Url $url)
    {
        parent::__construct($matcher, $url->asString());
    }

    public function __toString()
    {
        return $this->getMatcher()->asString() . ' ' . $this->getValue()->asString();
    }

    public static function fromCondition(Condition $condition)
    {
        return new self($condition->getMatcher(), new Url($condition->getValue()));
    }
}
