<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Body;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class BodyIsSameJsonAs extends BodyCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(Matcher::sameJson(), $string);
    }
}
