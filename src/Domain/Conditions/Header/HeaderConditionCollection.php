<?php

namespace Mcustiel\Phiremock\Domain\Conditions\Header;

use Mcustiel\Phiremock\Domain\AbstractArrayCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderName;

/**
 * @method HeaderCondition current()
 */
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
     * @return HeaderName
     */
    public function key()
    {
        return new HeaderName(parent::key());
    }
}
