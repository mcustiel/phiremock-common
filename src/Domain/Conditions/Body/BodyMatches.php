<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Body;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\Pattern;

class BodyMatches extends BodyCondition
{
    public function __construct(Pattern $pattern)
    {
        parent::__construct(Matcher::matches(), $pattern);
    }
}
