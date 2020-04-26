<?php

namespace Mcustiel\Phiremock\Domain\Http;

use Mcustiel\Phiremock\Domain\BinaryInfo;

class BinaryBody extends Body
{
    public function __construct(string $body)
    {
        parent::__construct(
            base64_decode(substr($body, BinaryInfo::BINARY_BODY_PREFIX_LENGTH), true)
        );
    }

    public function asString(): string
    {
        return BinaryInfo::BINARY_BODY_PREFIX . base64_encode(parent::asString());
    }

    public function isTextBody(): bool
    {
        return false;
    }
}
