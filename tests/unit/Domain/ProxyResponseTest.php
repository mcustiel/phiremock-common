<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\ProxyResponse;
use Mcustiel\Phiremock\Domain\Response;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Mcustiel\Phiremock\Domain\ProxyResponse
 * @covers \Mcustiel\Phiremock\Domain\Response
 */
class ProxyResponseTest extends ResponseTest
{
    /** @var Uri|MockObject */
    private $uri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uri = $this->createMock(Uri::class);
    }

    public function testIsProxyResponse(): void
    {
        $response = $this->getResponseInstance();
        $this->assertTrue($response->isProxyResponse());
    }

    public function testReturnsUrlCorrectly(): void
    {
        /** @var ProxyResponse $response */
        $response = $this->getResponseInstance();
        $this->assertSame($this->uri, $response->getUri());
    }

    protected function getResponseInstance(
        ?Delay $delay = null,
        ?ScenarioState $scenarioState = null
    ): Response {
        return new ProxyResponse($this->uri, $delay, $scenarioState);
    }
}
