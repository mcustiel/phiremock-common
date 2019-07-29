<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Url;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class UrlIsEqualTo extends UrlCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(Matcher::equalTo(), $string);
    }
}
