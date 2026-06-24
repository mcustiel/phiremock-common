<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Domain\Condition\Json;
use Mcustiel\Phiremock\Domain\Condition\Matchers\JsonEquals;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Json::class)]
#[CoversClass(JsonEquals::class)]
class JsonEqualsTest extends TestCase
{
    public function testMatchesJsonScalars(): void
    {
        $this->assertTrue((new JsonEquals(new Json('true')))->matches('true'));
        $this->assertTrue((new JsonEquals(new Json('null')))->matches('null'));
        $this->assertTrue((new JsonEquals(new Json('"potato"')))->matches('"potato"'));
        $this->assertTrue((new JsonEquals(new Json('1.0')))->matches('1.0'));
    }

    public function testDoesNotMatchInvalidJsonTextAsScalar(): void
    {
        $this->assertFalse((new JsonEquals(new Json('"potato"')))->matches('potato'));
    }

    public function testMatchesJsonObjectsRegardlessOfKeyOrder(): void
    {
        $matcher = new JsonEquals(new Json('{"name":"potato","enabled":true}'));

        $this->assertTrue($matcher->matches('{"enabled":true,"name":"potato"}'));
    }

    public function testDoesNotMatchNestedObjectsWithExtraKeys(): void
    {
        $matcher = new JsonEquals(new Json('{"user":{"name":"potato"}}'));

        $this->assertFalse($matcher->matches('{"user":{"name":"potato","enabled":true}}'));
    }
}
