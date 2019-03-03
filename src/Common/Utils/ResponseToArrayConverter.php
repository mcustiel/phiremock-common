<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Response;

class ResponseToArrayConverter
{
    public function convert(Response $response)
    {
        $responseArray = [];

        $responseArray['statusCode'] = $response->getStatusCode()->asInt();
        if ($response->getDelayMillis()->asInt() > 0) {
            $responseArray['delayMillis'] = $response->getDelayMillis()->asInt();
        }
        $responseArray['body'] = $response->getBody()->asString();
        if (!$response->getHeaders()->isEmpty()) {
            $this->convertHeaders($response, $responseArray);
        }

        return $responseArray;
    }

    private function convertHeaders(Response $response, array &$responseArray)
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
