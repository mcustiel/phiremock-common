<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

final class HeaderContains extends HeaderCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(Matcher::contains(), $string);
    }
}
