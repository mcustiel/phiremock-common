<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverter;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Delay;
use PHPUnit\Framework\TestCase;

class ResponseToArrayConverterTest extends TestCase
{
    /** @var ResponseToArrayConverter */
    private $converter;

    protected function setUp()
    {
        $this->converter = new ResponseToArrayConverter();
    }

    public function testConvertsADefaultResponseToArray()
    {
        $response = HttpResponse::createEmpty();

        $responseArray = $this->converter->convert($response);
        $this->assertSame(
            [
                'statusCode'  => 200,
                'delayMillis' => 0,
                'body'        => '',
            ],
            $responseArray
        );
    }

    public function testConvertsAResponseWithValuesSetToArray()
    {
        $headersCollection = new HeadersCollection();
        $headersCollection->setHeader(
            new Header(
                new HeaderName('Content-Type'),
                new HeaderValue('text/plain')
            )
        );
        $response = new HttpResponse(
            new StatusCode(404),
            new Body('I am the body.'),
            $headersCollection,
            new Delay(0)
        );

        $responseArray = $this->converter->convert($response);
        $this->assertSame(
            [
                'statusCode'  => 404,
                'delayMillis' => 0,
                'body'        => 'I am the body.',
                'headers'     => [
                    'Content-Type' => 'text/plain',
                ],
            ],
            $responseArray
        );
    }
}
