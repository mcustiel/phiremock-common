<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class ArrayToExpectationConverter
{
    /** @var ArrayToRequestConverter */
    private $arrayToRequestConverter;
    /** @var ArrayToResponseConverter */
    private $arrayToResponseConverter;

    public function __construct(
        ArrayToRequestConverter $arrayToRequestConverter,
        ArrayToResponseConverter $arrayToResponseConverter
    ) {
        $this->arrayToRequestConverter = $arrayToRequestConverter;
        $this->arrayToResponseConverter = $arrayToResponseConverter;
    }

    /**
     * @param array $expectationArray
     *
     * @return Expectation
     */
    public function convert(array $expectationArray)
    {
        $expectation = new Expectation();
        $this->setRequest($expectationArray, $expectation);
        $this->ensureResponseXorProxyToAreSet($expectationArray);

        if (isset($expectationArray['response'])) {
            $response = $this->arrayToResponseConverter->convert($expectationArray['response']);
            $expectation->setResponse($response);
        }

        if (!empty($expectationArray['proxyTo'])) {
            $expectation->setProxyTo(new Uri($expectationArray['proxyTo']));
        }
        if (!empty($expectationArray['newScenarioState'])) {
            $expectation->setNewScenarioState(new ScenarioState($expectationArray['newScenarioState']));
        }
        if (!empty($expectationArray['priority'])) {
            $expectation->setPriority(new Priority((int) $expectationArray['priority']));
        }
        if (!empty($expectationArray['scenarioName'])) {
            $expectation->setScenarioName(new ScenarioName($expectationArray['scenarioName']));
        }
        if (!empty($expectationArray['scenarioStateIs'])) {
            $expectation->setScenarioStateIs(new ScenarioState($expectationArray['scenarioStateIs']));
        }

        return $expectation;
    }

    private function ensureResponseXorProxyToAreSet($expectationArray)
    {
        if (!empty($expectationArray['response']) && !empty($expectationArray['proxyTo'])
            || empty($expectationArray['response']) && empty($expectationArray['proxyTo'])) {
            throw new \InvalidArgumentException('One of response or proxyTo is needed');
        }
    }

    private function setRequest(array $expectationArray, Expectation $expectation)
    {
        if (!isset($expectationArray['request'])) {
            throw new \InvalidArgumentException('Expectation request is not set');
        }
        $request = $this->arrayToRequestConverter->convert($expectationArray['request']);
        $expectation->setRequest($request);
    }
}
