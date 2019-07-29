<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain;

use Mcustiel\Phiremock\Domain\Conditions\BinaryBody\BinaryBodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\BinaryBody\BinaryBodyMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodCondition;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodMatcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlCondition;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlMatcher;
use PHPUnit\Framework\TestCase;

class ConditionTest extends TestCase
{
    public function classesProvider()
    {
        return [
            [MethodCondition::class, MethodMatcher::equalTo()],
            [BinaryBodyCondition::class, BinaryBodyMatcher::equalTo()],
            [BodyCondition::class, BodyMatcher::contains()],
            [UrlCondition::class, UrlMatcher::contains()],
            [HeaderCondition::class, HeaderMatcher::contains()],
        ];
    }

    /** @dataProvider classesProvider */
    public function testGettersWorksCorrectly($className, $matcher)
    {
        $value = new StringValue('potato');
        $condition = new $className($matcher, $value);
        $this->assertSame($matcher, $condition->getMatcher());
        $this->assertSame($value, $condition->getValue());
    }
}
