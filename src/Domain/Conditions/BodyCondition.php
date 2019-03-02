<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Http\Body;

class BodyCondition extends Condition
{
    const LONG_CONTENT = '--VERY LONG CONTENTS--';

    public function __construct(Matcher $matcher, Body $body)
    {
        parent::__construct($matcher, $body->asString());
    }

    public function __toString()
    {
        $value = $this->getValue()->asString();

        return $this->getMatcher()->asString() . ' => ' .
            (isset($value[2000]) ? self::LONG_CONTENT : $value);
    }

    public static function fromCondition(Condition $condition)
    {
        return new self($condition->getMatcher(), new Body($condition->getValue()));
    }
}
