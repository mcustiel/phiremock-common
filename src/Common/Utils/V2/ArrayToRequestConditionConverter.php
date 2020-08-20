<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mcustiel\Phiremock\Common\Utils\V2;

use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter as ArrayToRequestConditionConverterInterface;
use Mcustiel\Phiremock\Common\Utils\V1\ArrayToRequestConditionConverter as ArrayToRequestConditionConverterV1;
use Mcustiel\Phiremock\Domain\Condition\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderConditionIterator;
use Mcustiel\Phiremock\Domain\Condition\Conditions\MethodCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Condition\Matchers\MatcherFactory;
use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ArrayToRequestConditionConverter implements ArrayToRequestConditionConverterInterface //  extends ArrayToRequestConditionConverterV1
{
    const ALLOWED_OPTIONS = [
        'scenarioStateIs' => null,
        'method'          => null,
        'url'             => null,
        'body'            => null,
        'headers'         => null,
    ];

    /** @var MatcherFactory */
    private $matcherFactory;

    public function __construct()
    {
        $this->matcherFactory = new MatcherFactory();
    }

    public function convert(array $requestArray): Conditions
    {
        $this->ensureNotInvalidOptionsAreProvided($requestArray);

        return new Conditions(
            $this->convertMethodCondition($requestArray),
            $this->convertUrlCondition($requestArray),
            $this->convertBodyCondition($requestArray),
            $this->convertHeadersConditions($requestArray),
            $this->convertScenarioState($requestArray)
        );
    }

    protected function ensureNotInvalidOptionsAreProvided(array $requestArray): void
    {
        $invalidOptions = array_diff_key($requestArray, static::ALLOWED_OPTIONS);
        if (!empty($invalidOptions)) {
            throw new \Exception('Unknown request conditions: ' . var_export($invalidOptions, true));
        }
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
                    $this->convertHeaderCondition($header)
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

    protected function getMatcherFactory(): MatcherFactory
    {
        return $this->matcherFactory;
    }

    protected function convertMethodCondition(array $requestArray): ?MethodCondition
    {
        if (!empty($requestArray['method'])) {
            $methodCondition = $requestArray['method'];
            if (!\is_array($methodCondition)) {
                throw new \InvalidArgumentException('Method condition is invalid: ' . var_export($methodCondition, true));
            }
            $value = current($methodCondition);
            if (!\is_string($value)) {
                throw new \InvalidArgumentException('Invalid condition value. Expected string, got: ' . \gettype($value));
            }

            return new MethodCondition(
                $this->getMatcherFactory()->createFrom(key($methodCondition), $value)
            );
        }

        return null;
    }
}
