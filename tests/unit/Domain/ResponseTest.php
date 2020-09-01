<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Response;
use PHPUnit\Framework\TestCase;

abstract class ResponseTest extends TestCase
{
    /** @var Delay|TestCase */
    private $delay;
    /** @var ScenarioState|TestCase */
    private $scenarioState;

    protected function setUp(): void
    {
        $this->delay = $this->createMock(Delay::class);
        $this->scenarioState = $this->createMock(ScenarioState::class);
    }

    public function creationDataProvider(): array
    {
        $delay = $this->createMock(Delay::class);
        $scenarioState = $this->createMock(ScenarioState::class);

        return [
            'all null'            => [null, null],
            'delay null'          => [null, $scenarioState],
            'scenario state null' => [$delay, null],
            'all set'             => [$delay, $scenarioState],
        ];
    }

    /** @dataProvider creationDataProvider */
    public function testReturnsCreationData($delay, $scenarioState): void
    {
        $response = $this->getResponseInstance($delay, $scenarioState);

        $this->assertSame($delay, $response->getDelayMillis());
        $this->assertSame($scenarioState, $response->getNewScenarioState());
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
        $this->assertFalse($response->isHttpResponse());
    }

    public function testIsProxyResponse(): void
    {
        $response = $this->getResponseInstance();
        $this->assertFalse($response->isProxyResponse());
    }

    abstract protected function getResponseInstance(
        ?Delay $delay = null,
        ?ScenarioState $scenarioState = null
    ): Response;
}
