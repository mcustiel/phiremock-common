<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Condition\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\FormFieldConditionIterator;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderConditionIterator;
use Mcustiel\Phiremock\Domain\Condition\Conditions\MethodCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Mcustiel\Phiremock\Domain\Conditions */
class ConditionsTest extends TestCase
{
    /** @var MethodCondition|MockObject */
    private $method;
    /** @var UrlCondition|MockObject */
    private $url;
    /** @var BodyCondition|MockObject */
    private $body;
    /** @var HeaderConditionIterator|MockObject */
    private $headers;
    /** @var FormFieldConditionIterator|MockObject */
    private $formFields;
    /** @var ScenarioState|MockObject */
    private $scenarioState;

    protected function setUp(): void
    {
        $this->method = $this->createMock(MethodCondition::class);
        $this->url = $this->createMock(UrlCondition::class);
        $this->body = $this->createMock(BodyCondition::class);
        $this->headers = new HeaderConditionIterator();
        $this->scenarioState = $this->createMock(ScenarioState::class);
    }

    public function testReturnsTheCorrectConstructorArguments(): void
    {
        $conditions = new Conditions(
            $this->method,
            $this->url,
            $this->body,
            $this->headers,
            $this->formFields,
            $this->scenarioState
        );
        $this->assertSame($this->method, $conditions->getMethod());
        $this->assertSame($this->url, $conditions->getUrl());
        $this->assertSame($this->body, $conditions->getBody());
        $this->assertSame($this->headers, $conditions->getHeaders());
        $this->assertSame($this->formFields, $conditions->getFormFields());
        $this->assertSame($this->scenarioState, $conditions->getScenarioState());
    }
}
