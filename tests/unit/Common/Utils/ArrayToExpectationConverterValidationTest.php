<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverterLocator;
use Mcustiel\Phiremock\Common\Utils\V1\ArrayToExpectationConverter as V1ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\V2\ArrayToExpectationConverter as V2ArrayToExpectationConverter;
use Mcustiel\Phiremock\Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArrayToExpectationConverterLocator::class)]
#[CoversClass(V1ArrayToExpectationConverter::class)]
#[CoversClass(V2ArrayToExpectationConverter::class)]
class ArrayToExpectationConverterValidationTest extends TestCase
{
    public function testV1RejectsNonIntegerPriority(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->convert(['request' => [], 'priority' => 'abc']);
    }

    public function testV2RejectsNonIntegerPriority(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->convert(['version' => '2', 'priority' => 'abc']);
    }

    private function convert(array $expectationArray): void
    {
        $locator = (new Factory())->createArrayToExpectationConverterLocator();
        $locator->locate($expectationArray)->convert($expectationArray);
    }
}
