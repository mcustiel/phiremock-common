<?php

namespace Mcustiel\Phiremock\Domain\Conditions\BinaryBody;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

final class BinaryBodyIsEqualTo extends BinaryBodyCondition
{
    public function __construct(StringValue $string)
    {
        parent::__construct(Matcher::equalTo(), $string);
    }
}
