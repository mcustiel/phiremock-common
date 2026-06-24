<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\BinaryInfo;
use Mcustiel\Phiremock\Domain\Http\BinaryBody;
use Mcustiel\Phiremock\Domain\Http\Body;

class BodyHelper
{
    public static function getBodyObject(string $body): Body
    {
        if (!self::isBinaryBody($body)) {
            return new Body($body);
        }

        return new BinaryBody(self::decodeNetworkSafeBinaryBody($body));
    }

    private static function decodeNetworkSafeBinaryBody(string $body): string
    {
        $decodedBody = base64_decode(substr($body, BinaryInfo::BINARY_BODY_PREFIX_LENGTH), true);
        if (false === $decodedBody) {
            throw new \InvalidArgumentException('Invalid base64 encoded binary body');
        }

        return $decodedBody;
    }

    private static function isBinaryBody(string $body): bool
    {
        return BinaryInfo::BINARY_BODY_PREFIX === substr($body, 0, BinaryInfo::BINARY_BODY_PREFIX_LENGTH);
    }
}
