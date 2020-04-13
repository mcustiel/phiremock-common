<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Body;

use Mcustiel\Phiremock\Domain\Condition;

class BodyCondition extends Condition
{
    const LONG_CONTENT = '--VERY LONG CONTENTS--';

    public function __toString()
    {
        $value = $this->getValue()->asString();

        return $this->getMatcher()->asString() . ' => ' .
            (isset($value[2000]) ? self::LONG_CONTENT : $value);
    }
}
