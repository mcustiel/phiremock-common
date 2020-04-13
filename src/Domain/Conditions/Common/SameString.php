<?php
namespace Mcustiel\Phiremock\Domain\Conditions\Common;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;

class SameString extends Condition
{
    public function __construct(StringValue $value)
    {
        parent::__construct(Matcher::sameString(), $value);
    }
}
