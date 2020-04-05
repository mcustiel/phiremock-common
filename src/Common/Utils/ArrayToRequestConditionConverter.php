<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\Body\BodyMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderConditionIterator;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderMatcher;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodCondition;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodMatcher;
use Mcustiel\Phiremock\Domain\Conditions\StringValue;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlCondition;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlMatcher;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\Method;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ArrayToRequestConditionConverter
{
    public function convert(array $requestArray): Conditions
    {
        return new Conditions(
            $this->convertMethodCondition($requestArray['request']),
            $this->convertUrlCondition($requestArray['request']),
            $this->convertBodyCondition($requestArray['request']),
            $this->convertHeadersConditions($requestArray['request']),
            $this->convertScenarioState($requestArray)
        );
    }

    protected function convertHeadersConditions(array $requestArray): ?HeaderConditionIterator
    {
        var_export('headers');
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

    protected function convertHeaderCondition($header): HeaderCondition
    {
        var_export('header');
        if (!\is_array($header)) {
            throw new \InvalidArgumentException('Headers condition is invalid: ' . var_export($header, true));
        }

        return new HeaderCondition(
            new HeaderMatcher(key($header)),
            new StringValue(current($header))
        );
    }

    protected function convertUrlCondition(array $requestArray): ?UrlCondition
    {
        var_export('url');
        if (!empty($requestArray['url'])) {
            $url = $requestArray['url'];
            if (!\is_array($url)) {
                throw new \InvalidArgumentException('Url condition is invalid: ' . var_export($url, true));
            }

            return new UrlCondition(new UrlMatcher(key($url)), new StringValue(current($url)));
        }

        return null;
    }

    protected function convertMethodCondition(array $requestArray): ?MethodCondition
    {
        var_export('method');
        if (!empty($requestArray['method'])) {
            $method = $requestArray['method'];

            return new MethodCondition(
                MethodMatcher::equalTo(),
                new Method($method)
            );
        }

        return null;
    }

    protected function convertBodyCondition(array $requestArray): ?BodyCondition
    {
        if (!empty($requestArray['body'])) {
            $body = $requestArray['body'];
            if (!\is_array($body)) {
                throw new \InvalidArgumentException('Body condition is invalid: ' . var_export($body, true));
            }

            //$bodyContents = current($body);

            return new BodyCondition(
                new BodyMatcher(key($body)),
                new StringValue(current($body))
            );
        }

        return null;
    }

    protected function convertScenarioState(array $requestArray): ?ScenarioState
    {
        if (!empty($requestArray['scenarioStateIs'])) {
            return new ScenarioState($requestArray['scenarioStateIs']);
        }

        return null;
    }
}
