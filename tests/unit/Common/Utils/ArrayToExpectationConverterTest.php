<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\MockConfig;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\RequestConditions;
use PHPUnit\Framework\TestCase;

class ArrayToExpectationConverterTest extends TestCase
{
    /** @var ArrayToRequestConditionConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $requestConverter;
    /** @var ArrayToHttpResponseConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $responseConverter;
    /** @var ArrayToStateConditionsConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $locator;
    /** @var ArrayToExpectationConverter */
    private $expectationConverter;

    protected function setUp()
    {
        $this->requestConverter = $this->createMock(ArrayToRequestConditionConverter::class);
        $this->locator = $this->createMock(ArrayToResponseConverterLocator::class);
        $this->responseConverter = $this->createMock(ArrayToHttpResponseConverter::class);
        $this->expectationConverter = new ArrayToExpectationConverter(
            $this->requestConverter,
            $this->locator
        );
    }

    public function testConvertsAnArrayWithNullValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(RequestConditions::class);
        $response = $this->createMock(HttpResponse::class);

        $expectationArray = [
            'request'          => $requestArray,
            'response'         => $responseArray,
            'proxyTo'          => null,
            'newScenarioState' => null,
            'scenarioStateIs'  => null,
            'scenarioName'     => null,
            'priority'         => null,
        ];
        $this->locator->expects($this->once())
            ->method('locate')
            ->with($this->identicalTo($responseArray))
            ->willReturn($this->responseConverter);
        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($requestArray))
            ->willReturn($request);
        $this->responseConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($responseArray))
            ->willReturn($response);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(MockConfig::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertNull($expectation->getScenarioName());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(0, $expectation->getPriority()->asInt());
    }

    public function testConvertsAnArrayWithUnsetValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(RequestConditions::class);
        $response = $this->createMock(HttpResponse::class);

        $expectationArray = [
            'request'  => $requestArray,
            'response' => $responseArray,
        ];
        $this->locator->expects($this->once())
            ->method('locate')
            ->with($this->identicalTo($responseArray))
            ->willReturn($this->responseConverter);
        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($requestArray))
            ->willReturn($request);
        $this->responseConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($responseArray))
            ->willReturn($response);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(MockConfig::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertNull($expectation->getScenarioName());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(0, $expectation->getPriority()->asInt());
    }

    public function testConvertsAnArrayWithoutNullValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(RequestConditions::class);
        $response = $this->createMock(HttpResponse::class);

        $expectationArray = [
            'request'          => $requestArray,
            'response'         => $responseArray,
            'newScenarioState' => 'tomato',
            'scenarioStateIs'  => 'potato',
            'scenarioName'     => 'banana',
            'priority'         => 3,
        ];
        $this->locator->expects($this->once())
            ->method('locate')
            ->with($this->identicalTo($responseArray))
            ->willReturn($this->responseConverter);
        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($requestArray))
            ->willReturn($request);
        $this->responseConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($responseArray))
            ->willReturn($response);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(MockConfig::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertInstanceOf(ScenarioName::class, $expectation->getScenarioName());
        $this->assertSame('banana', $expectation->getScenarioName()->asString());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(3, $expectation->getPriority()->asInt());
    }
}
