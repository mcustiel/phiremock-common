<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Conditions\Body\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodCondition;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodMatcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlCondition;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlMatcher;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\RequestConditions;

class ArrayToRequestConditionConverter
{
    public function convert(array $requestArray)
    {
        if (!isset($requestArray['method'])) {
            throw new \InvalidArgumentException('Method is not set');
        }

        return new RequestConditions(
            $this->convertMethodCondition($requestArray),
            $this->convertUrlCondition($requestArray),
            $this->convertBodyCondition($requestArray),
            $this->convertHeadersConditions($requestArray),
            $this->convertScenarioState($requestArray)
        );
    }

    private function convertHeadersConditions(array $requestArray)
    {
        if (!empty($requestArray['headers'])) {
            $headers = $requestArray['headers'];
            if (!\is_array($headers)) {
                throw new \InvalidArgumentException('Headers condition is invalid: ' . var_export($headers, true));
            }
            $headersCollection = new HeaderConditionCollection();
            foreach ($headers as $headerName => $header) {
                $headersCollection->setHeaderCondition(
                    new HeaderName($headerName),
                    $this->convertHeaderCondition(
                        $header
                    )
                );
            }

            return $headersCollection->iterator();
        }

        return null;
    }

    private function convertHeaderCondition($header)
    {
        if (!\is_array($header)) {
            throw new \InvalidArgumentException('Headers condition is invalid: ' . var_export($header, true));
        }

        return new HeaderCondition(
            new HeaderMatcher(key($header)),
            new StringValue(current($header))
        );
    }

    private function convertUrlCondition(array $requestArray)
    {
        if (!empty($requestArray['url'])) {
            $url = $requestArray['url'];
            if (!\is_array($url)) {
                throw new \InvalidArgumentException('Url condition is invalid: ' . var_export($url, true));
            }

            return new UrlCondition(new UrlMatcher(key($url)), new StringValue(current($url)));
        }

        return null;
    }

    private function convertMethodCondition(array $requestArray)
    {
        $method = $requestArray['method'];
        if (!\is_array($method)) {
            throw new \InvalidArgumentException('Method condition is invalid: ' . var_export($method, true));
        }

        return new MethodCondition(
            new MethodMatcher(key($method)),
            new StringValue(current($method))
        );
    }

    private function convertBodyCondition(array $requestArray)
    {
        if (!empty($requestArray['body'])) {
            $body = $requestArray['body'];
            if (!\is_array($body)) {
                throw new \InvalidArgumentException('Body condition is invalid: ' . var_export($body, true));
            }

            return new BodyCondition(
                new BodyMatcher(key($body)),
                new StringValue(current($body))
            );
        }

        return null;
    }

    /** @return \Mcustiel\Phiremock\Domain\Options\ScenarioState|null */
    private function convertScenarioState(array $requestArray)
    {
        if (!empty($requestArray['scenarioStateIs'])) {
            return new ScenarioState($requestArray['scenarioStateIs']);
        }

        return null;
    }
}
