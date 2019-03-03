<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverter;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Request;
use Mcustiel\Phiremock\Domain\Response;
use PHPUnit\Framework\TestCase;

class ArrayToExpectationConverterTest extends TestCase
{
    /** @var ArrayToRequestConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $requestConverter;
    /** @var ArrayToResponseConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $responseConverter;
    /** @var ArrayToExpectationConverter */
    private $expectationConverter;

    protected function setUp()
    {
        $this->requestConverter = $this->createMock(ArrayToRequestConverter::class);
        $this->responseConverter = $this->createMock(ArrayToResponseConverter::class);
        $this->expectationConverter = new ArrayToExpectationConverter(
            $this->requestConverter,
            $this->responseConverter
        );
    }

    public function testConvertsAnArrayWithNullValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $expectationArray = [
            'request'          => $requestArray,
            'response'         => $responseArray,
            'proxyTo'          => null,
            'newScenarioState' => null,
            'scenarioStateIs'  => null,
            'scenarioName'     => null,
            'priority'         => null,
        ];
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
        $this->assertNull($expectation->getNewScenarioState());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(0, $expectation->getPriority()->asInt());
        $this->assertNull($expectation->getProxyTo());
        $this->assertNull($expectation->getScenarioName());
        $this->assertNull($expectation->getScenarioStateIs());
    }

    public function testConvertsAnArrayWithUnsetValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $expectationArray = [
            'request'  => $requestArray,
            'response' => $responseArray,
        ];
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
        $this->assertNull($expectation->getNewScenarioState());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(0, $expectation->getPriority()->asInt());
        $this->assertNull($expectation->getProxyTo());
        $this->assertNull($expectation->getScenarioName());
        $this->assertNull($expectation->getScenarioStateIs());
    }

    public function testConvertsAnArrayWithoutNullValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $expectationArray = [
            'request'          => $requestArray,
            'response'         => $responseArray,
            'newScenarioState' => 'tomato',
            'scenarioStateIs'  => 'potato',
            'scenarioName'     => 'banana',
            'priority'         => 3,
        ];
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
        $this->assertInstanceOf(ScenarioState::class, $expectation->getNewScenarioState());
        $this->assertSame('tomato', $expectation->getNewScenarioState()->asString());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(3, $expectation->getPriority()->asInt());
        $this->assertNull($expectation->getProxyTo());
        $this->assertInstanceOf(ScenarioName::class, $expectation->getScenarioName());
        $this->assertSame('banana', $expectation->getScenarioName()->asString());
        $this->assertInstanceOf(ScenarioState::class, $expectation->getScenarioStateIs());
        $this->assertSame('potato', $expectation->getScenarioStateIs()->asString());
    }
}
