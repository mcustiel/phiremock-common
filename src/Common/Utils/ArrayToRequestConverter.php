<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Matcher;
use Mcustiel\Phiremock\Domain\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\Method;
use Mcustiel\Phiremock\Domain\Http\Url;
use Mcustiel\Phiremock\Domain\Request;

class ArrayToRequestConverter
{
    public function convert(array $requestArray)
    {
        if (!isset($requestArray['method'])) {
            throw new \InvalidArgumentException('Method is not set');
        }
        $request = new Request(new Method($requestArray['method']));

        if (!empty($requestArray['body'])) {
            $this->convertBodyCondition($requestArray['body'], $request);
        }
        if (!empty($requestArray['url'])) {
            $this->convertUrlCondition($requestArray['url'], $request);
        }
        if (!empty($requestArray['headers'])) {
            $this->convertHeadersConditions($requestArray['headers'], $request);
        }

        return $request;
    }

    private function convertHeadersConditions($headers, Request $request)
    {
        if (!\is_array($headers)) {
            throw new \InvalidArgumentException(
                'Headers condition is invalid: ' . var_export($headers, true)
            );
        }
        foreach ($headers as $headerName => $header) {
            $this->convertHeaderCondition(new HeaderName($headerName), $header, $request);
        }
    }

    private function convertHeaderCondition(HeaderName $headerName, $header, Request $request)
    {
        if (!\is_array($header)) {
            throw new \InvalidArgumentException(
                'Headers condition is invalid: ' . var_export($header, true)
            );
        }
        $request->getHeaders()->setHeaderCondition(
            $headerName,
            new HeaderCondition(
                new Matcher(key($header)),
                new HeaderValue(current($header))
            )
        );
    }

    private function convertUrlCondition($url, Request $request)
    {
        if (!\is_array($url)) {
            throw new \InvalidArgumentException(
                'Url condition is invalid: ' . var_export($url, true)
            );
        }
        $request->setUrl(
            new UrlCondition(new Matcher(key($url)), new Url(current($url)))
        );
    }

    private function convertBodyCondition($body, Request $request)
    {
        if (!\is_array($body)) {
            throw new \InvalidArgumentException(
                'Body condition is invalid: ' . var_export($body, true)
            );
        }
        $request->setBody(
            new BodyCondition(new Matcher(key($body)), new Body(current($body)))
        );
    }
}
