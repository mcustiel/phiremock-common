<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Http\HeaderName;

class RequestConditionToArrayConverter
{
    public function convert(Conditions $request): array
    {
        $requestArray = [];

        $this->convertMethod($request, $requestArray);
        $this->convertUrl($request, $requestArray);
        $this->convertBody($request, $requestArray);
        $this->convertHeaders($request, $requestArray);

        return $requestArray;
    }

    protected function convertHeaders(Conditions $request, array &$requestArray): void
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
                    $headerCondition->getMatcher()->getName() => $headerCondition->getValue()->asString(),
                ];
            }
            $requestArray['headers'] = $headersArray;
        }
    }

    protected function convertBody(Conditions $request, array &$requestArray): void
    {
        $body = $request->getBody();
        $requestArray['body'] = null === $body ? null : [
            $body->getMatcher()->getName() => $body->getValue()->asString(),
        ];
    }

    protected function convertUrl(Conditions $request, array &$requestArray): void
    {
        $url = $request->getUrl();
        $requestArray['url'] = null === $url ? null : [
            $url->getMatcher()->getName() => $url->getValue()->asString(),
        ];
    }

    protected function convertMethod(Conditions $request, array &$requestArray): void
    {
        $method = $request->getMethod();
        $requestArray['method'] = null === $method ? null : $method->getValue()->asString();
    }
}
