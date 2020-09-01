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

/**
 * @covers \Mcustiel\Phiremock\Domain\HttpResponse
 * @covers \Mcustiel\Phiremock\Domain\Response
 */
class HttpResponseTest extends ResponseTest
{
    /** @var StatusCode|MockObject */
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
    }

    public function testIsHttpResponse(): void
    {
        $response = $this->getResponseInstance();
        $this->assertTrue($response->isHttpResponse());
    }

    public function initDataProvider(): array
    {
        $statusCode = $this->createMock(StatusCode::class);
        $body = $this->createMock(Body::class);
        $headers = $this->createMock(HeadersCollection::class);

        return [
            'all null'         => [$statusCode, null, null],
            'only body set'    => [$statusCode, $body, null],
            'only headers set' => [$statusCode, null, $headers],
            'all set '         => [$statusCode, $body, $headers],
        ];
    }

    /** @dataProvider initDataProvider */
    public function testReturnsHttpResponseCreationData($statusCode, $body, $headers): void
    {
        $response = new HttpResponse($statusCode, $body, $headers);
        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame($body, $response->getBody());
        $this->assertSame($headers, $response->getHeaders());
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
            ->willReturn(true);
        $response = new HttpResponse($this->statusCode, $this->body, $this->headers);
        $this->assertFalse($response->hasHeaders());
    }

    public function testReportsHeadersPresentWhenNotNullAndNotEmpty(): void
    {
        $this->headers->expects($this->once())
            ->method('isEmpty')
            ->willReturn(false);
        $response = new HttpResponse($this->statusCode, $this->body, $this->headers);
        $this->assertTrue($response->hasHeaders());
    }

    protected function getResponseInstance(
        ?Delay $delay = null,
        ?ScenarioState $scenarioState = null
    ): Response {
        return new HttpResponse(
            $this->statusCode,
            $this->body,
            $this->headers,
            $delay, $scenarioState
        );
    }
}
