<?php
namespace Mcustiel\Phiremock\Domain\Conditions\Common;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\ConditionValue;

class Equals extends Condition
{
    public function __construct(ConditionValue $value)
    {
        parent::__construct(Matcher::equalTo(), $value);
    }
}
