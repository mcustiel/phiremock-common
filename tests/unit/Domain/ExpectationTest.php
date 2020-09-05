<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Domain\Version;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Mcustiel\Phiremock\Domain\Expectation */
class ExpectationTest extends TestCase
{
    /** @var Conditions|MockObject */
    private $requestConditions;

    /** @var ScenarioName|MockObject */
    private $scenarioName;

    /** @var Response|MockObject */
    private $response;

    /** @var Priority|MockObject */
    private $priority;

    /** @var Version|MockObject */
    private $version;

    protected function setUp(): void
    {
        $this->requestConditions = $this->createMock(Conditions::class);
        $this->scenarioName = $this->createMock(ScenarioName::class);
        $this->response = $this->createMock(Response::class);
        $this->priority = $this->createMock(Priority::class);
        $this->version = $this->createMock(Version::class);
    }

    public function testReturnsTheCorrectConstructorArguments(): void
    {
        $expectation = new Expectation(
            $this->requestConditions,
            $this->response,
            $this->scenarioName,
            $this->priority,
            $this->version
            );
        $this->assertSame($this->requestConditions, $expectation->getRequest());
        $this->assertSame($this->response, $expectation->getResponse());
        $this->assertSame($this->scenarioName, $expectation->getScenarioName());
        $this->assertSame($this->priority, $expectation->getPriority());
        $this->assertSame($this->version, $expectation->getVersion());
    }

    public function testReportsIfPropertiesArePresent(): void
    {
        $expectation = new Expectation(
            $this->requestConditions,
            $this->response,
            $this->scenarioName,
            $this->priority,
            $this->version
        );
        $this->assertTrue($expectation->hasPriority());
        $this->assertTrue($expectation->hasScenarioName());
    }

    public function testReportsIfPropertiesAreAbsent(): void
    {
        $expectation = new Expectation(
            $this->requestConditions,
            $this->response
        );
        $this->assertFalse($expectation->hasPriority());
        $this->assertFalse($expectation->hasScenarioName());
    }

    public function testUsesDefaultVersionIfNotProvided(): void
    {
        $expectation = new Expectation(
            $this->requestConditions,
            $this->response
        );
        $this->assertSame('1', $expectation->getVersion()->asString());
    }

    public function testOverwritesThePriority(): void
    {
        $priority = $this->createMock(Priority::class);
        $expectation = new Expectation(
            $this->requestConditions,
            $this->response,
            null,
            $this->priority
        );
        $this->assertSame($this->priority, $expectation->getPriority());
        $expectation->setPriority($priority);
        $this->assertSame($priority, $expectation->getPriority());
    }
}
