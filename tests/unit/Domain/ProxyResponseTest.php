<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\ProxyResponse;
use Mcustiel\Phiremock\Domain\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mcustiel\Phiremock\Domain\ProxyResponse
 * @covers \Mcustiel\Phiremock\Domain\Response
 *
 * @internal
 */
class ProxyResponseTest extends TestCase
{
    /** @var MockObject|Uri */
    protected $uri;

    /** @var Delay|MockObject */
    private $delay;

    /** @var MockObject|ScenarioState */
    private $scenarioState;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uri = $this->createMock(Uri::class);
        $this->delay = $this->createMock(Delay::class);
        $this->scenarioState = $this->createMock(ScenarioState::class);
    }

    /** @dataProvider creationDataProvider */
    public function testReturnsCreationData($delay, $scenarioState): void
    {
        $testCase = new /**
         * @coversNothing
         */
        class('dummy') extends TestCase {
            public function dummy(): void {}
        };
        $uri = $testCase->createMock(Uri::class);

        $response = new ProxyResponse($uri, $delay, $scenarioState);

        $this->assertSame($delay, $response->getDelayMillis());
        $this->assertSame($scenarioState, $response->getNewScenarioState());
    }

    public static function creationDataProvider(): array
    {
        $testCase = new /**
         * @coversNothing
         */
        class('dummy') extends TestCase {
            public function dummy(): void {}
        };
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
        $response = static::getResponseInstance();
        $this->assertFalse($response->isHttpResponse());
    }

    public function testReturnsUrlCorrectly(): void
    {
        /** @var ProxyResponse $response */
        $response = $this->getResponseInstance();
        $this->assertSame($this->uri, $response->getUri());
    }

    private function getResponseInstance(
        ?Delay $delay = null,
        ?ScenarioState $scenarioState = null
    ): Response {
        return new ProxyResponse($this->uri, $delay, $scenarioState);
    }
}
