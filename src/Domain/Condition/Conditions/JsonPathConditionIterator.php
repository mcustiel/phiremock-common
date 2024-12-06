<?php

namespace Mcustiel\Phiremock\Domain\Condition\Conditions;

use Mcustiel\Phiremock\Domain\AbstractArrayIterator;
use Mcustiel\Phiremock\Domain\Http\JsonPathName;

/** @method JsonPathCondition current() */
final class JsonPathConditionIterator extends AbstractArrayIterator
{
    public function __toString()
    {
        $string = '';
        /** @var JsonPathName $pathName */
        /** @var JsonPathCondition $condition */
        foreach ($this as $pathName => $condition) {
            $string .= $pathName->asString() . ' => ' . $condition->__toString();
        }
        return $string;
    }

    /** @return JsonPathName */
    public function key()
    {
        return new JsonPathName(parent::key());
    }
}
