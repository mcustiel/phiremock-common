<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Http\HeaderName;

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

    protected function convertHeaders(Conditions $request, array &$requestArray)
    {
        $headers = $request->getHeaders();
        if ($headers === null) {
            $requestArray['headers'] = null;
        } else {
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

    protected function convertBody(Conditions $request, array &$requestArray)
    {
        $body = $request->getBody();
        $requestArray['body'] = null === $body ? null : [
            $body->getMatcher()->asString() => $body->getValue()->asString(),
        ];
    }

    protected function convertUrl(Conditions $request, array &$requestArray)
    {
        $url = $request->getUrl();
        $requestArray['url'] = null === $url ? null : [
            $url->getMatcher()->asString() => $url->getValue()->asString(),
        ];
    }

    protected function convertMethod(Conditions $request, array &$requestArray)
    {
        $method = $request->getMethod();
        $requestArray['method'] = null === $method ? null : $method->getValue()->asString();
    }
}
