<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\Pattern;

final class HeaderMatches extends HeaderCondition
{
    public function __construct(Pattern $pattern)
    {
        parent::__construct(Matcher::matches(), $pattern);
    }
}
