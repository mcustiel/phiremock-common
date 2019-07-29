<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderMatcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodCondition;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodMatcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlCondition;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlMatcher;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\RequestConditions;
use PHPUnit\Framework\TestCase;

class RequestToArrayConverterTest extends TestCase
{
    /** @var RequestConditionToArrayConverter */
    private $converter;

    protected function setUp()
    {
        $this->converter = new RequestConditionToArrayConverter();
    }

    public function testConvertsADefaultRequestToArray()
    {
        $request = new RequestConditions(new MethodCondition(new MethodMatcher(MatchersEnum::EQUAL_TO), new StringValue('GET')));

        $requestArray = $this->converter->convert($request);
        $this->assertSame(
            ['method' => ['isSameString' => 'GET']],
            $requestArray
        );
    }

    public function testConvertsARequestWithValuesSetToArray()
    {
        $request = new RequestConditions(
            new MethodCondition(new MethodMatcher(MatchersEnum::EQUAL_TO), new StringValue('POST')),
            new UrlCondition(new UrlMatcher(MatchersEnum::CONTAINS), new StringValue('/potato')),
            new BodyCondition(new BodyMatcher(MatchersEnum::MATCHES), new StringValue('I am the body.'))
        );
        $request->getHeaders()->setHeaderCondition(
            new HeaderName('Content-Type'),
            new HeaderCondition(
                new HeaderMatcher(MatchersEnum::SAME_STRING),
                new StringValue('text/plain')
            )
        );

        $requestArray = $this->converter->convert($request);
        $this->assertSame(
            [
                'method'  => [MatchersEnum::SAME_STRING => 'POST'],
                'url'     => [MatchersEnum::CONTAINS => '/potato'],
                'body'    => [MatchersEnum::MATCHES => 'I am the body.'],
                'headers' => [
                    'Content-Type' => [MatchersEnum::SAME_STRING => 'text/plain'],
                ],
            ],
            $requestArray
        );
    }
}
