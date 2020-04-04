<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Response;

class HttpResponseToArrayConverter extends ResponseToArrayConverter
{
    /** @param HttpResponse $response */
    public function convert(Response $response)
    {
        $responseArray = [];
        $responseArray['statusCode'] = $response->getStatusCode()->asInt();
        $responseArray['body'] = $response->getBody()->asString();
        if (!$response->getHeaders()->isEmpty()) {
            $this->convertHeaders($response, $responseArray);
        }

        return array_merge($responseArray, parent::convert($response));
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
