<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Condition\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderConditionIterator;
use Mcustiel\Phiremock\Domain\Condition\Conditions\MethodCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Condition\Matchers\MatcherFactory;
use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;
use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ArrayToRequestConditionConverter
{
    private $matcherFactory;

    public function __construct()
    {
        $this->matcherFactory = new MatcherFactory();
    }

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

    protected function convertHeaderCondition($headerCondition): HeaderCondition
    {
        if (!\is_array($headerCondition)) {
            throw new \InvalidArgumentException('Headers condition is invalid: ' . var_export($headerCondition, true));
        }
        $value = current($headerCondition);
        if (!\is_string($value)) {
            throw new \InvalidArgumentException('Invalid condition value. Expected string, got: ' . \gettype($value));
        }

        return new HeaderCondition(
            $this->matcherFactory->createFrom(key($headerCondition), $value)
        );
    }

    protected function convertUrlCondition(array $requestArray): ?UrlCondition
    {
        if (!empty($requestArray['url'])) {
            $urlCondition = $requestArray['url'];
            if (!\is_array($urlCondition)) {
                throw new \InvalidArgumentException('Url condition is invalid: ' . var_export($urlCondition, true));
            }
            $value = current($urlCondition);
            if (!\is_string($value)) {
                throw new \InvalidArgumentException('Invalid condition value. Expected string, got: ' . \gettype($value));
            }

            return new UrlCondition(
                $this->matcherFactory->createFrom(key($urlCondition), $value)
            );
        }

        return null;
    }

    protected function convertMethodCondition(array $requestArray): ?MethodCondition
    {
        if (!empty($requestArray['method'])) {
            $method = $requestArray['method'];
            if (!\is_string($method)) {
                throw new \InvalidArgumentException('Invalid condition value. Expected string, got: ' . \gettype($value));
            }

            return new MethodCondition(
                $this->matcherFactory->createFrom(MatchersEnum::SAME_STRING, $method)
            );
        }

        return null;
    }

    protected function convertBodyCondition(array $requestArray): ?BodyCondition
    {
        if (!empty($requestArray['body'])) {
            $bodyCondition = $requestArray['body'];
            if (!\is_array($bodyCondition)) {
                throw new \InvalidArgumentException('Body condition is invalid: ' . var_export($bodyCondition, true));
            }
            $value = current($bodyCondition);
            if (!\is_string($value)) {
                throw new \InvalidArgumentException('Invalid condition value. Expected string, got: ' . \gettype($value));
            }

            return new BodyCondition(
                $this->matcherFactory->createFrom(key($bodyCondition), $value)
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
