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
        $body = $response->getBody();
        $responseArray['body'] = $body === null ? null : $body->asString();
        $headers = $response->getHeaders();
        if ($headers && !$headers->isEmpty()) {
            $responseArray['headers'] = $this->getConvertHeaders($response, $responseArray);
        } else {
            $responseArray['headers'] = null;
        }

        return array_merge($responseArray, parent::convert($response));
    }

    private function getConvertHeaders(HttpResponse $response): array
    {
        $headers = $response->getHeaders();
        $headersArray = [];
        /** @var Header $header */
        foreach ($headers as $header) {
            $headersArray[$header->getName()->asString()] = $header->getValue()->asString();
        }
        return $headersArray;
    }
}
