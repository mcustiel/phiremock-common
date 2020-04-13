<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Body;

use Mcustiel\Phiremock\Domain\Conditions\StringValue;

final class BodyIsSameStringAs extends BodyCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(BodyMatcher::sameString(), $string);
    }
}
