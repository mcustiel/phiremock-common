<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

use Mcustiel\Phiremock\Domain\AbstractArrayCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderName;

class HeaderConditionCollection extends AbstractArrayCollection
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

    public function setHeaderCondition(HeaderName $header, HeaderCondition $condition)
    {
        parent::set($header->asString(), $condition);
    }

    /**
     * @return HeaderCondition
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @return HeaderCondition
     */
    public function key()
    {
        return new HeaderName(parent::key());
    }
}
