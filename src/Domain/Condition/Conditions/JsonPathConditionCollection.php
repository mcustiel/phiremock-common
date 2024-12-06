<?php

namespace Mcustiel\Phiremock\Domain\Condition\Conditions;

use Mcustiel\Phiremock\Domain\AbstractArrayCollection;
use Mcustiel\Phiremock\Domain\Http\JsonPathName;

/** @method JsonPathCondition current() */
final class JsonPathConditionCollection extends AbstractArrayCollection
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

    public function setPathCondition(JsonPathName $path, JsonPathCondition $condition)
    {
        parent::set($path->asString(), $condition);
    }

    /** @return JsonPathName */
    public function key()
    {
        return new JsonPathName(parent::key());
    }

    public function iterator()
    {
        return new JsonPathConditionIterator($this->array);
    }
}
