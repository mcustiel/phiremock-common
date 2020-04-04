<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\HttpResponseToArrayConverter;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use PHPUnit\Framework\TestCase;

class ResponseToArrayConverterTest extends TestCase
{
    /** @var HttpResponseToArrayConverter */
    private $converter;

    protected function setUp(): void
    {
        $this->converter = new HttpResponseToArrayConverter();
    }

    public function testConvertsADefaultResponseToArray(): void
    {
        $response = HttpResponse::createEmpty();

        $responseArray = $this->converter->convert($response);
        $this->assertSame(
            [
                'statusCode'       => 200,
                'body'             => '',
                'delayMillis'      => null,
            ],
            $responseArray
        );
    }

    public function testConvertsAResponseWithValuesSetToArray(): void
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
            new Delay(0),
            new ScenarioState('potato')
        );

        $responseArray = $this->converter->convert($response);
        $this->assertSame(
            [
                'statusCode'  => 404,
                'body'        => 'I am the body.',
                'headers'     => [
                    'Content-Type' => 'text/plain',
                ],
                'delayMillis'      => 0,
            ],
            $responseArray
        );
    }
}
