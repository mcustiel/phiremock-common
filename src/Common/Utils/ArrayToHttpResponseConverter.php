<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ArrayToHttpResponseConverter
{
    public function convert(array $responseArray, ScenarioState $newScenarioState = null)
    {
        if (!isset($responseArray['statusCode'])) {
            throw new \InvalidArgumentException('Status code is not set');
        }

        $body = null;
        if (!empty($responseArray['body'])) {
            $body = new Body($responseArray['body']);
        }
        $delay = null;
        if (!empty($responseArray['delayMillis'])) {
            $delay = new Delay($responseArray['delayMillis']);
        }
        $headers = null;
        if (!empty($responseArray['headers'])) {
            $headers = $this->convertHeaders($responseArray['headers']);
        }

        return new HttpResponse(
            new StatusCode($responseArray['statusCode']),
            $body,
            $headers,
            $delay,
            $newScenarioState
        );
    }

    private function convertHeaders($headers)
    {
        if (!\is_array($headers)) {
            throw new \InvalidArgumentException(
                'Response headers are invalid: ' . var_export($headers, true)
            );
        }

        $headerCollection = new HeadersCollection();
        foreach ($headers as $headerName => $headerValue) {
            $headerCollection->setHeader(
                new Header(
                    new HeaderName($headerName),
                    new HeaderValue($headerValue)
                )
            );
        }

        return $headerCollection;
    }
}
