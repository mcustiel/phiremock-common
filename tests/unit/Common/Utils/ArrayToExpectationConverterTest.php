<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\MockConfig;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\ProxyResponse;
use Mcustiel\Phiremock\Domain\RequestConditions;
use Mcustiel\Phiremock\Domain\StateConditions;
use PHPUnit\Framework\TestCase;

class ArrayToExpectationConverterTest extends TestCase
{
    /** @var ArrayToRequestConditionConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $requestConverter;
    /** @var ArrayToHttpResponseConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $responseConverter;
    /** @var ArrayToStateConditionsConverter|\PHPUnit_Framework_MockObject_MockObject */
    private $stateConditionsConverter;
    /** @var ArrayToExpectationConverter */
    private $expectationConverter;

    protected function setUp()
    {
        $this->requestConverter = $this->createMock(ArrayToRequestConditionConverter::class);
        $this->responseConverter = $this->createMock(ArrayToHttpResponseConverter::class);
        $this->stateConditionsConverter = $this->createMock(ArrayToStateConditionsConverter::class);
        $this->expectationConverter = new ArrayToExpectationConverter(
            $this->requestConverter,
            $this->responseConverter,
            $this->stateConditionsConverter
        );
    }

    public function testConvertsAnArrayWithNullValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(RequestConditions::class);
        $response = $this->createMock(HttpResponse::class);
        $state = $this->createMock(StateConditions::class);

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
        $this->stateConditionsConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($expectationArray))
            ->willReturn($state);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(MockConfig::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertSame($state, $expectation->getStateConditions());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(0, $expectation->getPriority()->asInt());
    }

    public function testConvertsAnArrayWithUnsetValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(RequestConditions::class);
        $response = $this->createMock(HttpResponse::class);
        $state = $this->createMock(StateConditions::class);

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
        $this->stateConditionsConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($expectationArray))
            ->willReturn($state);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(MockConfig::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertSame($state, $expectation->getStateConditions());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(0, $expectation->getPriority()->asInt());
    }

    public function testConvertsAnArrayWithoutNullValuesToExpectation()
    {
        $requestArray = ['tomato'];
        $responseArray = ['potato'];

        $request = $this->createMock(RequestConditions::class);
        $response = $this->createMock(HttpResponse::class);
        $state = $this->createMock(StateConditions::class);

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
        $this->stateConditionsConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($expectationArray))
            ->willReturn($state);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(MockConfig::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertSame($response, $expectation->getResponse());
        $this->assertSame($state, $expectation->getStateConditions());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(3, $expectation->getPriority()->asInt());
    }

    public function testConvertsAnArrayWithProxyResponseToExpectation()
    {
        $requestArray = ['tomato'];

        $request = $this->createMock(RequestConditions::class);
        $state = $this->createMock(StateConditions::class);

        $expectationArray = [
            'request'          => $requestArray,
            'proxyTo'          => 'https://www.wikipedia.com/',
            'newScenarioState' => 'tomato',
            'scenarioStateIs'  => 'potato',
            'scenarioName'     => 'banana',
            'priority'         => 3,
        ];
        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($requestArray))
            ->willReturn($request);
        $this->responseConverter->expects($this->never())
            ->method('convert');
        $this->stateConditionsConverter->expects($this->once())
            ->method('convert')
            ->with($this->identicalTo($expectationArray))
            ->willReturn($state);

        $expectation = $this->expectationConverter->convert($expectationArray);
        $this->assertInstanceOf(MockConfig::class, $expectation);
        $this->assertSame($request, $expectation->getRequest());
        $this->assertInstanceOf(ProxyResponse::class, $expectation->getResponse());
        $this->assertSame('https://www.wikipedia.com/', $expectation->getResponse()->getUri()->asString());
        $this->assertSame($state, $expectation->getStateConditions());
        $this->assertInstanceOf(Priority::class, $expectation->getPriority());
        $this->assertSame(3, $expectation->getPriority()->asInt());
    }
}
