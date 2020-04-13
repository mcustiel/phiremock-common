<?php
namespace Mcustiel\Phiremock\Domain\Conditions\Common;

use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\Pattern;

class RegexMatch extends Condition
{
    public function __construct(Pattern $regex)
    {
        parent::__construct(Matcher::matches(), $regex);
    }
}
