<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Url;

use Mcustiel\Phiremock\Domain\Conditions\StringValue;

final class UrlIsSameStringAs extends UrlCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(UrlMatcher::sameString(), $string);
    }
}
