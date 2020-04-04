<?php

namespace Mcustiel\Phiremock\Common\Utils\V2;

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
        $body = $response->getBody();
        $responseArray['body'] = $body === null ? null : $body->asString();
        $headers = $response->getHeaders();
        if ($headers && !$headers->isEmpty()) {
            $this->convertHeaders($response, $responseArray);
        } else {
            $headers = null;
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
