<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class HeaderIsSameStringAs extends HeaderCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(Matcher::sameString(), $string);
    }
}
