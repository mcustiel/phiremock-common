<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mcustiel\Phiremock\Domain\HttpResponse
 * @covers \Mcustiel\Phiremock\Domain\Response
 *
 * @internal
 */
class HttpResponseTest extends TestCase
{
    /** @var Delay|MockObject */
    private $delay;

    /** @var MockObject|ScenarioState */
    private $scenarioState;

    /** @var MockObject|StatusCode */
    private $statusCode;

    /** @var Body|MockObject */
    private $body;

    /** @var HeadersCollection|MockObject */
    private $headers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->statusCode = $this->createMock(StatusCode::class);
        $this->body = $this->createMock(Body::class);
        $this->headers = $this->createMock(HeadersCollection::class);
        $this->delay = $this->createMock(Delay::class);
        $this->scenarioState = $this->createMock(ScenarioState::class);
    }

    public function testCreateEmptyResponseWithHelperMethod(): void
    {
        $response = HttpResponse::createEmpty();
        $this->assertTrue($response->isHttpResponse());
        $this->assertSame('', $response->getBody()->asString());
        $this->assertSame(200, $response->getStatusCode()->asInt());
        $this->assertFalse($response->hasHeaders());
    }

    /** @dataProvider initDataProvider */
    public function testReturnsHttpResponseCreationData($statusCode, $body, $headers): void
    {
        $response = new HttpResponse($statusCode, $body, $headers);
        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame($body, $response->getBody());
        $this->assertSame($headers, $response->getHeaders());
    }

    public static function initDataProvider(): array
    {
        $testCase = new /**
         * @coversNothing
         */
        class('dummy') extends TestCase {};
        $statusCode = $testCase->createMock(StatusCode::class);
        $body = $testCase->createMock(Body::class);
        $headers = $testCase->createMock(HeadersCollection::class);

        return [
            'all null' => [$statusCode, null, null],
            'only body set' => [$statusCode, $body, null],
            'only headers set' => [$statusCode, null, $headers],
            'all set ' => [$statusCode, $body, $headers],
        ];
    }

    public function testUsesDefaultStatusCodeIfNotProvided(): void
    {
        $response = new HttpResponse();
        $this->assertSame(200, $response->getStatusCode()->asInt());
    }

    public function testReportsBodyPresent(): void
    {
        $response = new HttpResponse($this->statusCode, null, $this->headers);
        $this->assertFalse($response->hasBody());

        $response = new HttpResponse($this->statusCode, $this->body, $this->headers);
        $this->assertTrue($response->hasBody());
    }

    public function testReportsHeadersAbsentWhenNull(): void
    {
        $response = new HttpResponse($this->statusCode, $this->body, null);
        $this->assertFalse($response->hasHeaders());
    }

    public function testReportsHeadersAbsentWhenNotNullButEmpty(): void
    {
        $this->headers->expects($this->once())
            ->method('isEmpty')
            ->willReturn(true)
        ;
        $response = new HttpResponse($this->statusCode, $this->body, $this->headers);
        $this->assertFalse($response->hasHeaders());
    }

    public function testReportsHeadersPresentWhenNotNullAndNotEmpty(): void
    {
        $this->headers->expects($this->once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $response = new HttpResponse($this->statusCode, $this->body, $this->headers);
        $this->assertTrue($response->hasHeaders());
    }

    /** @dataProvider creationDataProvider */
    public function testReturnsCreationData($delay, $scenarioState): void
    {
        $testCase = new /**
         * @coversNothing
         */
        class('dummy') extends TestCase {};
        $statusCode = $testCase->createMock(StatusCode::class);
        $body = $testCase->createMock(Body::class);
        $headers = $testCase->createMock(HeadersCollection::class);

        $response = new HttpResponse(
            $statusCode,
            $body,
            $headers,
            $delay,
            $scenarioState
        );
        static::getResponseInstance($delay, $scenarioState);

        $this->assertSame($delay, $response->getDelayMillis());
        $this->assertSame($scenarioState, $response->getNewScenarioState());
    }

    public static function creationDataProvider(): array
    {
        $testCase = new /**
         * @coversNothing
         */
        class('dummy') extends TestCase {};
        $delay = $testCase->createMock(Delay::class);
        $scenarioState = $testCase->createMock(ScenarioState::class);

        return [
            'all null' => [null, null],
            'delay null' => [null, $scenarioState],
            'scenario state null' => [$delay, null],
            'all set' => [$delay, $scenarioState],
        ];
    }

    public function testReportsDelayPresent(): void
    {
        $response = $this->getResponseInstance(null, $this->scenarioState);
        $this->assertFalse($response->hasDelayMillis());

        $response = $this->getResponseInstance($this->delay, $this->scenarioState);
        $this->assertTrue($response->hasDelayMillis());
    }

    public function testReportsScenarioStatePresent(): void
    {
        $response = $this->getResponseInstance($this->delay, null);
        $this->assertFalse($response->hasNewScenarioState());

        $response = $this->getResponseInstance($this->delay, $this->scenarioState);
        $this->assertTrue($response->hasNewScenarioState());
    }

    public function testIsHttpResponse(): void
    {
        $response = $this->getResponseInstance();
        $this->assertTrue($response->isHttpResponse());
    }

    public function testIsProxyResponse(): void
    {
        $response = $this->getResponseInstance();
        $this->assertFalse($response->isProxyResponse());
    }

    private function getResponseInstance(
        ?Delay $delay = null,
        ?ScenarioState $scenarioState = null
    ): Response {
        return new HttpResponse(
            $this->statusCode,
            $this->body,
            $this->headers,
            $delay,
            $scenarioState
        );
    }
}
