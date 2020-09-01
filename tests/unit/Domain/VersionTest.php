<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Version;
use PHPUnit\Framework\TestCase;

/** @covers \Mcustiel\Phiremock\Domain\Version */
class VersionTest extends TestCase
{
    public function validVersionProvider(): array
    {
        return [
            'version 1' => ['1'],
            'version 2' => ['2'],
        ];
    }

    /** @dataProvider validVersionProvider */
    public function testRetrievesValue($versionString): void
    {
        $version = new Version($versionString);
        $this->assertSame($versionString, $version->asString());
    }

    public function invalidVersionProvider(): array
    {
        return [
            'empty'       => [''],
            'version 0'   => ['0'],
            'version 1.1' => ['1.1'],
            'version 2.0' => ['2.0'],
            'version 3'   => ['3'],
            'alphabetic'  => ['a'],
        ];
    }

    /** @dataProvider invalidVersionProvider */
    public function testThrowsExceptionIfVersionIsInvalid($versionString): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Invalid version: %s', $versionString));
        new Version($versionString);
    }
}
