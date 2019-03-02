<?php

namespace Mcustiel\Phiremock\Domain\Http;

use Mcustiel\Phiremock\Domain\AbstractArrayCollection;

class HeadersCollection extends AbstractArrayCollection
{
    public function setHeader(Header $header)
    {
        parent::add($header);
    }

    /**
     * @return Header
     */
    public function current()
    {
        return parent::current();
    }
}
