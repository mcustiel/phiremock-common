<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\RequestToArrayConverter;
use Mcustiel\Phiremock\Domain\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\Method;
use Mcustiel\Phiremock\Domain\Http\Url;
use Mcustiel\Phiremock\Domain\Request;
use PHPUnit\Framework\TestCase;

class RequestToArrayConverterTest extends TestCase
{
    /** @var RequestToArrayConverter */
    private $converter;

    protected function setUp()
    {
        $this->converter = new RequestToArrayConverter();
    }

    public function testConvertsADefaultRequestToArray()
    {
        $request = new Request();

        $requestArray = $this->converter->convert($request);
        $this->assertSame(
            ['method' => 'GET'],
            $requestArray
        );
    }

    public function testConvertsARequestWithValuesSetToArray()
    {
        $request = new Request();
        $request->setMethod(new Method('post'));
        $request->setUrl(new UrlCondition(new Matcher(MatchersEnum::CONTAINS), new Url('/potato')));
        $request->setBody(
            new BodyCondition(new Matcher(MatchersEnum::MATCHES), new Body('I am the body.'))
        );
        $request->getHeaders()->setHeaderCondition(
            new HeaderName('Content-Type'),
            new HeaderCondition(
                new Matcher(MatchersEnum::SAME_STRING),
                new HeaderValue('text/plain')
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
