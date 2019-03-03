<?php

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverter;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\Response;
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
        $response = new Response();

        $responseArray = $this->converter->convert($response);
        $this->assertSame(
            [
                'statusCode' => 200,
                'body'       => '',
            ],
            $responseArray
        );
    }

    public function testConvertsAResponseWithValuesSetToArray()
    {
        $response = new Response();
        $response->setStatusCode(new StatusCode(404));
        $response->setBody(new Body('I am the body.'));
        $response->getHeaders()->setHeader(
            new Header(
                new HeaderName('Content-Type'),
                new HeaderValue('text/plain')
            )
        );

        $responseArray = $this->converter->convert($response);
        $this->assertSame(
            [
                'statusCode' => 404,
                'body'       => 'I am the body.',
                'headers'    => [
                    'Content-Type' => 'text/plain',
                ],
            ],
            $responseArray
        );
    }
}
