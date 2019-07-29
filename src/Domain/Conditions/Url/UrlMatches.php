<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Url;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\Pattern;

class UrlMatches extends UrlCondition
{
    public function __construct(Pattern $pattern)
    {
        parent::__construct(Matcher::matches(), $pattern);
    }
}
