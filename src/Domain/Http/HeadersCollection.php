<?php

namespace Mcustiel\Phiremock\Domain\Http;

use Mcustiel\Phiremock\Domain\AbstractArrayCollection;

/**
 * @method Header current()
 */
class HeadersCollection extends AbstractArrayCollection
{
    public function setHeader(Header $header)
    {
        parent::add($header);
    }
}
