<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Domain\Http;

use Mcustiel\Phiremock\Common\StringStream;
use Mcustiel\Phiremock\Domain\Http\Body;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Body::class)]
#[CoversClass(StringStream::class)]
class BodyTest extends TestCase
{
    public function testBodyStreamIsReadableFromTheBeginning(): void
    {
        $stream = (new Body('response body'))->asStream();

        $this->assertSame('response body', $stream->getContents());
    }
}
