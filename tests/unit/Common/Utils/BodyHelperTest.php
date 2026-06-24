<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\BodyHelper;
use Mcustiel\Phiremock\Domain\BinaryInfo;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BodyHelper::class)]
class BodyHelperTest extends TestCase
{
    public function testThrowsExceptionWhenBinaryBodyIsNotValidBase64(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        BodyHelper::getBodyObject(BinaryInfo::BINARY_BODY_PREFIX.'not-base64!');
    }
}
