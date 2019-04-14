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
use Mcustiel\Phiremock\Domain\RequestConditions;
use Mcustiel\Phiremock\Domain\Conditions\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ArrayToRequestConditionConverter
{
    public function convert(array $requestArray)
    {
        if (!isset($requestArray['method'])) {
            throw new \InvalidArgumentException('Method is not set');
        }

        return new RequestConditions(
            new Method($requestArray['method']),
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
                throw new \InvalidArgumentException(
                    'Headers condition is invalid: ' . var_export($headers, true)
                );
            }
            $headersCollection = new HeaderConditionCollection();
            foreach ($headers as $headerName => $header) {
                $headersCollection->setHeaderCondition(
                    $this->convertHeaderCondition(
                        new HeaderName($headerName),
                        $header
                    )
                );
            }

            return $headersCollection;
        }

        return null;
    }

    private function convertHeaderCondition(HeaderName $headerName, $header)
    {
        if (!\is_array($header)) {
            throw new \InvalidArgumentException(
                'Headers condition is invalid: ' . var_export($header, true)
            );
        }

        return new HeaderCondition(
            new Matcher(key($header)),
            new HeaderValue(current($header))
        );
    }

    private function convertUrlCondition(array $requestArray)
    {
        if (!empty($requestArray['url'])) {
            $url = $requestArray['url'];
            if (!\is_array($url)) {
                throw new \InvalidArgumentException(
                    'Url condition is invalid: ' . var_export($url, true)
                );
            }

            return new UrlCondition(new Matcher(key($url)), new Url(current($url)));
        }
        return null;
    }

    private function convertBodyCondition(array $requestArray)
    {
        if (!empty($requestArray['body'])) {
            $body = $requestArray['body'];
            if (!\is_array($body)) {
                throw new \InvalidArgumentException(
                    'Body condition is invalid: ' . var_export($body, true)
                );
            }

            return new BodyCondition(new Matcher(key($body)), new Body(current($body)));

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
