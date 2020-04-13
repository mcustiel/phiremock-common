<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Domain\HttpResponse;
use PHPUnit\Framework\TestCase;

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
            'body'        => null,
            'headers'     => null,
        ];
        /** @var HttpResponse $response */
        $response = $this->responseConverter->convert($responseArray);
        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode()->asInt());
        $this->assertNull($response->getDelayMillis());
        $this->assertNull($response->getNewScenarioState());
        $this->assertNull($response->getBody());
        $this->assertNull($response->getHeaders());
    }
}
