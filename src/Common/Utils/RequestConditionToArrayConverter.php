<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;

class RequestConditionToArrayConverter
{
    public function convert(Conditions $request)
    {
        $requestArray = [];

        $this->convertMethod($request, $requestArray);
        $this->convertUrl($request, $requestArray);
        $this->convertBody($request, $requestArray);
        $this->convertHeaders($request, $requestArray);

        return $requestArray;
    }

    private function convertHeaders(Conditions $request, array &$requestArray)
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

    private function convertBody(Conditions $request, array &$requestArray)
    {
        if (null !== $request->getBody()) {
            $body = $request->getBody();
            $requestArray['body'] = [
                $body->getMatcher()->asString() => $body->getValue()->asString(),
            ];
        }
    }

    private function convertUrl(Conditions $request, array &$requestArray)
    {
        if (null !== $request->getUrl()) {
            $url = $request->getUrl();
            $requestArray['url'] = [
                $url->getMatcher()->asString() => $url->getValue()->asString(),
            ];
        }
    }

    private function convertMethod(Conditions $request, array &$requestArray)
    {
        $method = $request->getMethod();
        $requestArray['method'] = [
            $method->getMatcher()->asString() => $method->getValue()->asString(),
        ];
    }
}
