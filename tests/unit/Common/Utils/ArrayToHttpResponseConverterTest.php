<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderConditionIterator;
use Mcustiel\Phiremock\Domain\Conditions\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodCondition;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlCondition;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Conditions;
use PHPUnit\Framework\TestCase;
use Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Domain\HttpResponse;

class ArrayToHttpResponseConverterTest extends TestCase
{
    /** @var ArrayToHttpResponseConverter */
    private $responseConverter;

    protected function setUp(): void
    {
        $this->responseConverter = new ArrayToHttpResponseConverter();
    }

    public function testConvertsAnArrayWithNullValuesToHttpResponse(): void
    {
        $responseArray = [
            'statusCode'  => null,
            'body'     => null,
            'headers' => null,
        ];
        /** @var HttpResponse $response */
        $response = $this->responseConverter->convert($responseArray);
        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode()->asInt());
        $this->assertNull($response->getDelayMillis());
        $this->assertNull($response->getNewScenarioState());
        $this->assertSame('', $response->getBody()->asString());
        $this->assertTrue($response->getHeaders()->isEmpty());
    }
}
