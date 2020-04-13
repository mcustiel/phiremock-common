<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Body;

use Mcustiel\Phiremock\Domain\Conditions\StringValue;

final class BodyContains extends BodyCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(BodyMatcher::contains(), $string);
    }
}
