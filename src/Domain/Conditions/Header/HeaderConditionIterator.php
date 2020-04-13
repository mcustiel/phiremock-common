<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\AbstractArrayIterator;
use Mcustiel\Phiremock\Domain\Http\HeaderName;

/** @method HeaderCondition current() */
final class HeaderConditionIterator extends AbstractArrayIterator
{
    public function __toString()
    {
        $string = '';
        /** @var HeaderName $headerName */
        /** @var HeaderCondition $headerCondition */
        foreach ($this as $headerName => $headerCondition) {
            $string .= $headerName->asString() . ' => ' . $headerCondition->__toString();
        }

        return $string;
    }

    /** @return HeaderName */
    public function key()
    {
        return new HeaderName(parent::key());
    }
}
