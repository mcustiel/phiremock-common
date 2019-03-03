<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConverter;
use Mcustiel\Phiremock\Domain\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\Method;
use Mcustiel\Phiremock\Domain\Request;
use PHPUnit\Framework\TestCase;

class ArrayToRequestConverterTest extends TestCase
{
    /** @var ArrayToRequestConverter */
    private $requestConverter;

    protected function setUp()
    {
        $this->requestConverter = new ArrayToRequestConverter();
    }

    public function testConvertsAnArrayWithNullValuesToRequest()
    {
        $requestArray = [
            'method'  => 'get',
            'url'     => null,
            'body'    => null,
            'headers' => null,
        ];

        $request = $this->requestConverter->convert($requestArray);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertNull($request->getUrl());
        $this->assertNull($request->getBody());
        $this->assertInstanceOf(Method::class, $request->getMethod());
        $this->assertSame('GET', $request->getMethod()->asString());
        $this->assertInstanceOf(HeaderConditionCollection::class, $request->getHeaders());
        $this->assertTrue($request->getHeaders()->isEmpty());
    }

    public function testConvertsAnArrayWithUnsetValuesToRequest()
    {
        $requestArray = ['method'  => 'get'];

        $request = $this->requestConverter->convert($requestArray);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertNull($request->getUrl());
        $this->assertNull($request->getBody());
        $this->assertInstanceOf(Method::class, $request->getMethod());
        $this->assertSame('GET', $request->getMethod()->asString());
        $this->assertInstanceOf(HeaderConditionCollection::class, $request->getHeaders());
        $this->assertTrue($request->getHeaders()->isEmpty());
    }

    public function testConvertsAnArrayWithoutNullValuesToRequest()
    {
        $requestArray = [
            'method'  => 'get',
            'url'     => [MatchersEnum::EQUAL_TO => '/potato'],
            'body'    => [MatchersEnum::EQUAL_TO => 'A tomato.'],
            'headers' => [
                'Content-Type' => [MatchersEnum::CONTAINS => 'javascript'],
            ],
        ];
        $request = $this->requestConverter->convert($requestArray);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(Method::class, $request->getMethod());
        $this->assertSame('GET', $request->getMethod()->asString());
        $this->assertInstanceOf(UrlCondition::class, $request->getUrl());
        $this->assertSame(MatchersEnum::EQUAL_TO, $request->getUrl()->getMatcher()->asString());
        $this->assertSame('/potato', $request->getUrl()->getValue()->asString());
        $this->assertInstanceOf(BodyCondition::class, $request->getBody());
        $this->assertSame(MatchersEnum::EQUAL_TO, $request->getBody()->getMatcher()->asString());
        $this->assertSame('A tomato.', $request->getBody()->getValue()->asString());
        $this->assertInstanceOf(HeaderConditionCollection::class, $request->getHeaders());
        $this->assertCount(1, $request->getHeaders());
        $request->getHeaders()->rewind();
        $headerName = $request->getHeaders()->key();
        $this->assertInstanceOf(HeaderName::class, $headerName);
        $this->assertSame('Content-Type', $headerName->asString());
        $headerCondition = $request->getHeaders()->current();
        $this->assertInstanceOf(HeaderCondition::class, $headerCondition);
        $this->assertSame(MatchersEnum::CONTAINS, $headerCondition->getMatcher()->asString());
        $this->assertSame('javascript', $headerCondition->getValue()->asString());
    }
}
