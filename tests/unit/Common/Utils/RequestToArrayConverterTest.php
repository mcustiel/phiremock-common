<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlCondition;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\Method;
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
        $request = new RequestConditions(new Method('get'));

        $requestArray = $this->converter->convert($request);
        $this->assertSame(
            ['method' => 'GET'],
            $requestArray
        );
    }

    public function testConvertsARequestWithValuesSetToArray()
    {
        $request = new RequestConditions(
            new Method('post'),
            new UrlCondition(new Matcher(MatchersEnum::CONTAINS), new StringValue('/potato')),
            new BodyCondition(new Matcher(MatchersEnum::MATCHES), new StringValue('I am the body.'))
        );
        $request->getHeaders()->setHeaderCondition(
            new HeaderName('Content-Type'),
            new HeaderCondition(
                new Matcher(MatchersEnum::SAME_STRING),
                new StringValue('text/plain')
            )
        );

        $requestArray = $this->converter->convert($request);
        $this->assertSame(
            [
                'method'  => 'POST',
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
