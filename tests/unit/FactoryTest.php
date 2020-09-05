<?php

namespace Mcustiel\Phiremock\Tests\Unit;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverterLocator;
use Mcustiel\Phiremock\Common\Utils\V1\Factory as FactoryV1;
use Mcustiel\Phiremock\Common\Utils\V2\Factory as FactoryV2;
use Mcustiel\Phiremock\Factory;

class FactoryTest
{
    /** @var Factory */
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new Factory();
    }

    public function methodAndClassProvider(): array
    {
        return [
            'createV1UtilsFactory'                     => ['createV1UtilsFactory', FactoryV1::class],
            'createV2UtilsFactory'                     => ['createV2UtilsFactory', FactoryV2::class],
            'createExpectationToArrayConverterLocator' => ['createExpectationToArrayConverterLocator', ExpectationToArrayConverterLocator::class],
            'createArrayToExpectationConverterLocator' => ['createArrayToExpectationConverterLocator', ArrayToExpectationConverterLocator::class],
        ];
    }

    /** @dataProvider methodAndClassProvider */
    public function testCreatesObjectsCorrectly($factoryMethod, $expectedClass): void
    {
        $this->assertInstanceOf($expectedClass, $this->factory->{$factoryMethod}());
    }
}
