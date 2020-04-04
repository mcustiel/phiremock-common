<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToConditionsConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator;
use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Version;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ArrayToExpectationConverterTest extends TestCase
{
    /** @var ArrayToRequestConditionConverter|MockObject */
    private $requestConverter;
    /** @var ArrayToHttpResponseConverter|MockObject */
    private $responseConverter;
    /** @var ArrayToResponseConverterLocator|MockObject */
    private $responseConverterLocator;
    /** @var ArrayToConditionsConverterLocator|MockObject */
    private $conditionsConverterLocator;
    /** @var ArrayToExpectationConverter */
    private $expectationConverter;

    protected function setUp(): void
    {
        $this->requestConverter = $this->createMock(ArrayToRequestConditionConverter::class);
        $this->responseConverterLocator = $this->createMock(ArrayToResponseConverterLocator::class);
        $this->responseConverter = $this->createMock(ArrayToHttpResponseConverter::class);
        $this->conditionsConverterLocator = $this->createMock(ArrayToConditionsConverterLocator::class);
        $this->expectationConverter = new ArrayToExpectationConverter(
            $this->conditionsConverterLocator,
            $this->responseConverterLocator
        );
    }

    public function testConvertsAnArrayWithNullValuesToExpectation(): void
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(Conditions::class);
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
        $this->conditionsConverterLocator->expects($this->once())
            ->method('locate')
            ->with($this->equalTo(new Version(1)))
            ->willReturn($this->requestConverter);
        $this->responseConverterLocator->expects($this->once())
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
        $this->assertInstanceOf(Expectation::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertFalse($expectation->hasScenarioName());
        $this->assertFalse($expectation->hasPriority());
    }

    public function testConvertsAnArrayWithUnsetValuesToExpectation(): void
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(Conditions::class);
        $response = $this->createMock(HttpResponse::class);

        $expectationArray = [
            'request'  => $requestArray,
            'response' => $responseArray,
        ];
        $this->responseConverterLocator->expects($this->once())
            ->method('locate')
            ->with($this->identicalTo($responseArray))
            ->willReturn($this->responseConverter);
        $this->conditionsConverterLocator->expects($this->once())
            ->method('locate')
            ->with($this->equalTo(new Version(1)))
            ->willReturn($this->requestConverter);
        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($requestArray))
            ->willReturn($request);
        $this->responseConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($responseArray))
            ->willReturn($response);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(Expectation::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertFalse($expectation->hasScenarioName());
        $this->assertFalse($expectation->hasPriority());
    }

    public function testConvertsAnArrayWithoutNullValuesToExpectation(): void
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(Conditions::class);
        $response = $this->createMock(HttpResponse::class);

        $expectationArray = [
            'request'          => $requestArray,
            'response'         => $responseArray,
            'newScenarioState' => 'tomato',
            'scenarioStateIs'  => 'potato',
            'scenarioName'     => 'banana',
            'priority'         => 3,
        ];
        $this->responseConverterLocator->expects($this->once())
            ->method('locate')
            ->with($this->identicalTo($responseArray))
            ->willReturn($this->responseConverter);
        $this->conditionsConverterLocator->expects($this->once())
            ->method('locate')
            ->with($this->equalTo(new Version(1)))
            ->willReturn($this->requestConverter);
        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($requestArray))
            ->willReturn($request);
        $this->responseConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($responseArray))
            ->willReturn($response);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(Expectation::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertInstanceOf(ScenarioName::class, $expectation->getScenarioName());
        $this->assertSame('banana', $expectation->getScenarioName()->asString());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(3, $expectation->getPriority()->asInt());
    }
}
