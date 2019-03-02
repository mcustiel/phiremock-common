<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use PHPUnit\Framework\TestCase;

class ConditionTest extends TestCase
{
    public function testGettersWorksCorrectly()
    {
        $matcher = new Matcher(MatchersEnum::CONTAINS);
        $value = 'potato';
        $condition = new Condition($matcher, $value);
        $this->assertSame($matcher, $condition->getMatcher());
        $this->assertSame($value, $condition->getValue());
    }
}
