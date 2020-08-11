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

namespace Mcustiel\Phiremock\Common\Utils\V1;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter as ArrayToExpectationConverterInterface;
use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Domain\Version;

class ArrayToExpectationConverter implements ArrayToExpectationConverterInterface
{
    const ALLOWED_OPTIONS = [
        'version'         => null,
        'scenarioName'    => null,
        'scenarioStateIs' => null,
        'newScenarioState'=> null,
        'priority'        => null,
        'proxyTo'         => null,
        'request'         => null,
        'response'        => null,
    ];

    /** @var ArrayToRequestConditionConverter */
    private $arrayToConditionsConverter;
    /** @var ArrayToResponseConverterLocator */
    private $arrayToResponseConverterLocator;

    public function __construct(
        ArrayToRequestConditionConverter $arrayToConditionsConverter,
        ArrayToResponseConverterLocator $arrayToResponseConverterLocator
    ) {
        $this->arrayToConditionsConverter = $arrayToConditionsConverter;
        $this->arrayToResponseConverterLocator = $arrayToResponseConverterLocator;
    }

    public function convert(array $expectationArray): Expectation
    {
        $this->ensureNotInvalidOptionsAreProvided($expectationArray);
        $version = $this->getVersion($expectationArray);
        $request = $this->convertRequest($expectationArray, $version);
        $response = $this->convertResponse($expectationArray);
        $scenarioName = $this->getScenarioName($expectationArray);
        $priority = $this->getPriority($expectationArray);

        return new Expectation($request, $response, $scenarioName, $priority, $version);
    }

    private function ensureNotInvalidOptionsAreProvided(array $expectationArray): void
    {
        $invalidOptions = array_diff_key($expectationArray, self::ALLOWED_OPTIONS);
        if (!empty($invalidOptions)) {
            throw new \Exception('Unknown expectation options: ' . var_export($invalidOptions, true));
        }
    }

    private function getVersion(array $expectationArray): Version
    {
        if (isset($expectationArray['version'])) {
            return new Version((int) $expectationArray['version']);
        }

        return new Version(1);
    }

    private function getPriority(array $expectationArray): ?Priority
    {
        $priority = null;
        if (!empty($expectationArray['priority'])) {
            $priority = new Priority((int) $expectationArray['priority']);
        }

        return $priority;
    }

    private function getScenarioName(array $expectationArray): ?ScenarioName
    {
        $scenarioName = null;
        if (!empty($expectationArray['scenarioName'])) {
            $scenarioName = new ScenarioName($expectationArray['scenarioName']);
        }

        return $scenarioName;
    }

    private function convertResponse(array $expectationArray): Response
    {
        if (!isset($expectationArray['response']) && !isset($expectationArray['proxyTo'])) {
            return new HttpResponse(new StatusCode(200), null, null, null, null);
        }
        if (!isset($expectationArray['proxyTo']) && !\is_array($expectationArray['response'])) {
            throw new \InvalidArgumentException('Invalid response definition: ' . var_export($expectationArray['response'], true));
        }

        return $this->arrayToResponseConverterLocator
            ->locate($expectationArray)
            ->convert($expectationArray);
    }

    private function convertRequest(array $expectationArray, Version $version): Conditions
    {
        if (!isset($expectationArray['request'])) {
            throw new \InvalidArgumentException('Expectation request is not set');
        }

        return $this->arrayToConditionsConverter->convert($expectationArray);
    }
}
