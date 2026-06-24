<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Domain\Condition\Json;
use Mcustiel\Phiremock\Domain\Condition\Matchers\JsonContains;
use Mcustiel\Phiremock\Domain\Condition\Matchers\MatcherFactory;
use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Json::class)]
#[CoversClass(JsonContains::class)]
#[CoversClass(MatcherFactory::class)]
#[CoversClass(MatchersEnum::class)]
class JsonContainsTest extends TestCase
{
    public function testJsonContainsMatcherIsRegistered(): void
    {
        $this->assertTrue(MatchersEnum::isValidMatcher(MatchersEnum::JSON_CONTAINS));
        $this->assertInstanceOf(
            JsonContains::class,
            (new MatcherFactory())->createFrom(MatchersEnum::JSON_CONTAINS, '{"name":"potato"}')
        );
    }

    public function testMatchesWhenRequestContainsConfiguredJson(): void
    {
        $matcher = new JsonContains(new Json('{"name":"potato"}'));

        $this->assertTrue($matcher->matches('{"name":"potato","enabled":true}'));
    }

    public function testDoesNotMatchWhenConfiguredJsonContainsMoreThanRequest(): void
    {
        $matcher = new JsonContains(new Json('{"name":"potato","enabled":true}'));

        $this->assertFalse($matcher->matches('{"name":"potato"}'));
    }

    public function testMatchesNestedContainedJson(): void
    {
        $matcher = new JsonContains(new Json('{"user":{"roles":{"admin":true}}}'));

        $this->assertTrue($matcher->matches('{"user":{"name":"potato","roles":{"admin":true,"editor":true}}}'));
    }

    public function testJsonContainsDoesNotMatchScalarJson(): void
    {
        $matcher = new JsonContains(new Json('true'));

        $this->assertFalse($matcher->matches('true'));
    }
}
