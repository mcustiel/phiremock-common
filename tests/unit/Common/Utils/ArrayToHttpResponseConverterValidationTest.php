<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\V1\ArrayToHttpResponseConverter as V1ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Common\Utils\V2\ArrayToHttpResponseConverter as V2ArrayToHttpResponseConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(V1ArrayToHttpResponseConverter::class)]
#[CoversClass(V2ArrayToHttpResponseConverter::class)]
class ArrayToHttpResponseConverterValidationTest extends TestCase
{
    public function testV2DefaultsMissingResponseDefinitionWithoutWarning(): void
    {
        $response = (new V2ArrayToHttpResponseConverter())->convert(['delayMillis' => 1000]);

        $this->assertSame(200, $response->getStatusCode()->asInt());
        $this->assertSame(1000, $response->getDelayMillis()->asInt());
    }

    public function testV1RejectsStringStatusCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new V1ArrayToHttpResponseConverter())->convert(['response' => ['statusCode' => '200']]);
    }

    public function testV2RejectsStringStatusCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new V2ArrayToHttpResponseConverter())->convert(['response' => ['statusCode' => '200']]);
    }
}
