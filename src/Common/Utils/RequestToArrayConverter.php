<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Request;

class RequestToArrayConverter
{
    public function convert(Request $request)
    {
        $requestArray = [];

        $requestArray['method'] = $request->getMethod()->asString();
        $this->convertUrl($request, $requestArray);
        $this->convertBody($request, $requestArray);
        $this->convertHeaders($request, $requestArray);

        return $requestArray;
    }

    private function convertHeaders(Request $request, array &$requestArray)
    {
        $headers = $request->getHeaders();
        if (!$headers->isEmpty()) {
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

    private function convertBody(Request $request, array &$requestArray)
    {
        if (null !== $request->getBody()) {
            $body = $request->getBody();
            $requestArray['body'] = [
                $body->getMatcher()->asString() => $body->getValue()->asString(),
            ];
        }
    }

    private function convertUrl(Request $request, array &$requestArray)
    {
        if (null !== $request->getUrl()) {
            $url = $request->getUrl();
            $requestArray['url'] = [
                $url->getMatcher()->asString() => $url->getValue()->asString(),
            ];
        }
    }
}
