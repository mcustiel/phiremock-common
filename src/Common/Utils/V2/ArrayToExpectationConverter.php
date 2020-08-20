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

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter as ArrayToExpectationConverterInterface;
use Mcustiel\Phiremock\Common\Utils\V1\ArrayToExpectationConverter as ArrayToExpectationConverterV1;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Version;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Domain\Conditions;

class ArrayToExpectationConverter implements ArrayToExpectationConverterInterface //extends ArrayToExpectationConverterV1
{
    const ALLOWED_OPTIONS = [
        'version'         => null,
        'scenarioName'    => null,
        'priority'        => null,
        'on'         => null,
        'then'        => null,
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
        $version = new Version('2');
        $request = $this->convertRequest($expectationArray);
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
        if (empty($expectationArray['then'])) {
            return new HttpResponse(new StatusCode(200), null, null, null, null);
        }

        return $this->arrayToResponseConverterLocator
            ->locate($expectationArray['then'])
            ->convert($expectationArray['then']);
    }

    private function convertRequest(array $expectationArray): Conditions
    {
        if (empty($expectationArray['on'])) {
            return new Conditions();
        }

        return $this->arrayToConditionsConverter->convert($expectationArray['on']);
    }
}
