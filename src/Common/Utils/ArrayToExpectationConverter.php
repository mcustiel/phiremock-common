<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Domain\Version;

class ArrayToExpectationConverter
{
    /** @var ArrayToConditionsConverterLocator */
    private $arrayToConditionsConverterLocator;
    /** @var ArrayToResponseConverterLocator */
    private $arrayToResponseConverterLocator;

    public function __construct(
        ArrayToConditionsConverterLocator $arrayToConditionsConverterLocator,
        ArrayToResponseConverterLocator $arrayToResponseConverterLocator
    ) {
        $this->arrayToConditionsConverterLocator = $arrayToConditionsConverterLocator;
        $this->arrayToResponseConverterLocator = $arrayToResponseConverterLocator;
    }

    public function convert(array $expectationArray): Expectation
    {
        $version = $this->getVersion($expectationArray);
        var_export('pre request');
        $request = $this->convertRequest($expectationArray, $version);
        var_export('response ');
        $response = $this->convertResponse($expectationArray);
        $scenarioName = $this->getScenarioName($expectationArray);
        $priority = $this->getPriority($expectationArray);

        return new Expectation($request, $response, $scenarioName, $priority);
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
        var_export('Convert response in expectation converter 0 ');
        if (!isset($expectationArray['response']) && !isset($expectationArray['proxyTo'])) {
            return new HttpResponse(new StatusCode(200), null, null, null, null);
        }
        var_export('Convert response in expectation converter 1 ');
        if (!isset($expectationArray['proxyTo']) && !\is_array($expectationArray['response'])) {
            throw new \InvalidArgumentException('Invalid response definition: ' . var_export($expectationArray['response'], true));
        }
        var_export('Convert response in expectation converter 2 ');

        return $this->arrayToResponseConverterLocator
            ->locate($expectationArray)
            ->convert($expectationArray);
    }

    private function convertRequest(array $expectationArray, Version $version)
    {
        if (!isset($expectationArray['request'])) {
            throw new \InvalidArgumentException('Expectation request is not set');
        }

        return $this->arrayToConditionsConverterLocator
            ->locate($version)
            ->convert($expectationArray);
    }
}
