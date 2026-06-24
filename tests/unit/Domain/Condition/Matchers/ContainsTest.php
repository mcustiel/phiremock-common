<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Domain\Condition\Matchers\Contains;
use Mcustiel\Phiremock\Domain\Condition\StringValue;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class ContainsTest extends TestCase
{
    /** @var Contains */
    private $matcher;

    protected function setUp(): void
    {
        $this->matcher = new Contains(new StringValue('Potato'));
    }

    public function testMatches(): void
    {
        $this->assertTrue($this->matcher->matches('Potato Tomato'));
        $this->assertTrue($this->matcher->matches('Tomato Potato'));
    }

    public function testDoesNotMatch(): void
    {
        $this->assertFalse($this->matcher->matches('Coconut'));
        $this->assertFalse($this->matcher->matches('Banana'));
        $this->assertFalse($this->matcher->matches(' '));
    }

    public function testPreservesScalarMatchingCompatibility(): void
    {
        $matcher = new Contains(new StringValue('23'));

        $this->assertTrue($matcher->matches(12345));
    }
}
