<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\RequestConditions;

class RequestConditionToArrayConverter
{
    public function convert(RequestConditions $request)
    {
        $requestArray = [];

        $this->convertMethod($request, $requestArray);
        $this->convertUrl($request, $requestArray);
        $this->convertBody($request, $requestArray);
        $this->convertHeaders($request, $requestArray);

        return $requestArray;
    }

    private function convertHeaders(RequestConditions $request, array &$requestArray)
    {
        $headers = $request->getHeaders();
        if ($headers !== null && !$headers->isEmpty()) {
            $headersArray = [];
            /** @var HeaderName $headerName */
            /** @var HeaderCondition $headerCondition */
            foreach ($headers as $headerName => $headerCondition) {
                $headersArray[$headerName->asString()] = [
                    $headerCondition->getMatcher()->asString() => $headerCondition->getValue()->asString(),
                ];
            }
            $requestArray['headers'] = $headersArray;
        }
    }

    private function convertBody(RequestConditions $request, array &$requestArray)
    {
        if (null !== $request->getBody()) {
            $body = $request->getBody();
            $requestArray['body'] = [
                $body->getMatcher()->asString() => $body->getValue()->asString(),
            ];
        }
    }

    private function convertUrl(RequestConditions $request, array &$requestArray)
    {
        if (null !== $request->getUrl()) {
            $url = $request->getUrl();
            $requestArray['url'] = [
                $url->getMatcher()->asString() => $url->getValue()->asString(),
            ];
        }
    }

    private function convertMethod(RequestConditions $request, array &$requestArray)
    {
        $method = $request->getMethod();
        $requestArray['method'] = [
            $method->getMatcher()->asString() => $method->getValue()->asString(),
        ];
    }
}
