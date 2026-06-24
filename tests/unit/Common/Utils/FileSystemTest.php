<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\FileSystem;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileSystem::class)]
class FileSystemTest extends TestCase
{
    public function testReturnsNormalizedPathWhenAbsoluteRootChildDoesNotExist(): void
    {
        $path = '/phiremock-common-missing-root-'.bin2hex(random_bytes(8)).'/file.txt';

        $this->assertSame($path, (new FileSystem())->getRealPath($path));
    }
}
