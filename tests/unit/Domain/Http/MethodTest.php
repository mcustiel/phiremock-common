<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Domain\Http;

use Mcustiel\Phiremock\Domain\Http\Method;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Method::class)]
class MethodTest extends TestCase
{
    public function testConstructingMethodDoesNotWriteToOutput(): void
    {
        $this->expectOutputString('');

        $method = new Method('GET');

        $this->assertSame('get', $method->asString());
    }
}
