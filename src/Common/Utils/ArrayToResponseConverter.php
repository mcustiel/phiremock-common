<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Response;

class ArrayToResponseConverter
{
    public function convert(array $responseArray)
    {
        if (!isset($responseArray['statusCode'])) {
            throw new \InvalidArgumentException('Status code is not set');
        }
        $response = new Response(new StatusCode($responseArray['statusCode']));

        if (!empty($responseArray['body'])) {
            $response->setBody(new Body($responseArray['body']));
        }
        if (!empty($responseArray['delayMillis'])) {
            $response->setDelayMillis(new Delay($responseArray['delayMillis']));
        }
        if (!empty($responseArray['headers'])) {
            $this->convertHeaders($responseArray['headers'], $response);
        }

        return $response;
    }

    private function convertHeaders($headers, Response $response)
    {
        if (!\is_array($headers)) {
            throw new \InvalidArgumentException(
                'Response headers are invalid: ' . var_export($headers, true)
            );
        }

        foreach ($headers as $headerName => $headerValue) {
            $response->getHeaders()->setHeader(
                new Header(
                    new HeaderName($headerName),
                    new HeaderValue($headerValue)
                )
            );
        }
    }
}
