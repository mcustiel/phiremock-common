<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\HttpResponse;

class ResponseToArrayConverter
{
    public function convert(HttpResponse $response)
    {
        $responseArray = [];

        $responseArray['statusCode'] = $response->getStatusCode()->asInt();
        if (null !== $response->getDelayMillis()) {
            $responseArray['delayMillis'] = $response->getDelayMillis()->asInt();
        }
        $responseArray['body'] = $response->getBody()->asString();
        if (!$response->getHeaders()->isEmpty()) {
            $this->convertHeaders($response, $responseArray);
        }

        return $responseArray;
    }

    private function convertHeaders(HttpResponse $response, array &$responseArray)
    {
        $headers = $response->getHeaders();
        $headersArray = [];
        /** @var Header $header */
        foreach ($headers as $header) {
            $headersArray[$header->getName()->asString()] = $header->getValue()->asString();
        }
        $responseArray['headers'] = $headersArray;
    }
}
