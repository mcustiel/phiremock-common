<?php

namespace Mcustiel\Phiremock\Domain\Http;

use Mcustiel\Phiremock\Domain\BinaryInfo;

class BinaryBody extends Body
{
    /**
     * @return string
     */
    public function asString()
    {
        return BinaryInfo::BINARY_BODY_PREFIX . base64_encode(parent::asString());
    }
}
