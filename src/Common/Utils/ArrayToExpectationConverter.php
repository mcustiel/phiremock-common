<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Response;

class ArrayToExpectationConverter
{
    /** @var ArrayToRequestConditionConverter */
    private $arrayToRequestConverter;
    /** @var ArrayToResponseConverterLocator */
    private $arrayToResponseConverterLocator;

    public function __construct(
        ArrayToRequestConditionConverter $arrayToRequestConditionsConverter,
        ArrayToResponseConverterLocator $arrayToResponseConverterLocator
    ) {
        $this->arrayToRequestConverter = $arrayToRequestConditionsConverter;
        $this->arrayToResponseConverterLocator = $arrayToResponseConverterLocator;
    }

    /**
     * @return Expectation
     */
    public function convert(array $expectationArray)
    {
        $request = $this->convertRequest($expectationArray);
        $response = $this->convertResponse($expectationArray);
        $scenarioName = $this->getScenarioName($expectationArray);
        $priority = $this->getPriority($expectationArray);

        return new Expectation($request, $response, $scenarioName, $priority);
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Options\Priority|null
     */
    private function getPriority(array $expectationArray)
    {
        $priority = null;
        if (!empty($expectationArray['priority'])) {
            $priority = new Priority((int) $expectationArray['priority']);
        }

        return $priority;
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Options\ScenarioName|null
     */
    private function getScenarioName(array $expectationArray)
    {
        $scenarioName = null;
        if (!empty($expectationArray['scenarioName'])) {
            $scenarioName = new ScenarioName($expectationArray['scenarioName']);
        }

        return $scenarioName;
    }

    /**
     * @return Response
     */
    private function convertResponse(array $expectationArray)
    {
        if (!isset($expectationArray['response'])) {
            throw new \InvalidArgumentException('Creating an expectation without response.');
        }

        return $this->arrayToResponseConverterLocator
            ->locate($expectationArray['response'])
            ->convert($expectationArray['response']);
    }

    private function convertRequest(array $expectationArray)
    {
        if (!isset($expectationArray['request'])) {
            throw new \InvalidArgumentException('Expectation request is not set');
        }

        return $this->arrayToRequestConverter->convert($expectationArray['request']);
    }
}
