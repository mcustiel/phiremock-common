<?php

namespace Mcustiel\Phiremock\Domain\Http;

use Mcustiel\Phiremock\Domain\BinaryInfo;

class BinaryBody extends Body
{
    public function __construct($body)
    {
        parent::__construct(base64_decode(substr($body, BinaryInfo::BINARY_BODY_PREFIX_LENGTH)));
    }

    /** @return string */
    public function asString()
    {
        return BinaryInfo::BINARY_BODY_PREFIX . base64_encode(parent::asString());
    }

    /** @return bool */
    public function isTextBody()
    {
        return false;
    }
}
