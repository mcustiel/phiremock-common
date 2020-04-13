<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Body;

use Mcustiel\Phiremock\Domain\Conditions\Pattern;

final class BodyMatches extends BodyCondition
{
    public function __construct(Pattern $pattern)
    {
        parent::__construct(BodyMatcher::matches(), $pattern);
    }
}
