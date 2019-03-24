<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\MockConfig;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\ProxyResponse;
use Mcustiel\Phiremock\Domain\Response;

class ArrayToExpectationConverter
{
    /** @var ArrayToRequestConditionConverter */
    private $arrayToRequestConverter;
    /** @var ArrayToHttpResponseConverter */
    private $arrayToResponseConverter;
    /** @var ArrayToStateConditionsConverter */
    private $arrayToStateConditionsConverter;

    public function __construct(
        ArrayToRequestConditionConverter $arrayToRequestConditionsConverter,
        ArrayToHttpResponseConverter $arrayToResponseConverter,
        ArrayToStateConditionsConverter $arrayToStateConditionsConverter
    ) {
        $this->arrayToRequestConverter = $arrayToRequestConditionsConverter;
        $this->arrayToResponseConverter = $arrayToResponseConverter;
        $this->arrayToStateConditionsConverter = $arrayToStateConditionsConverter;
    }

    /**
     * @param array $expectationArray
     *
     * @return MockConfig
     */
    public function convert(array $expectationArray)
    {
        $request = $this->convertRequest($expectationArray);
        $response = $this->convertResponse($expectationArray);
        $stateConditions = $this->arrayToStateConditionsConverter->convert($expectationArray);

        $priority = null;
        if (!empty($expectationArray['priority'])) {
            $priority = new Priority((int) $expectationArray['priority']);
        }

        return new MockConfig($request, $stateConditions, $response, $priority);
    }

    /**
     * @param array $expectationArray
     *
     * @return null|\Mcustiel\Phiremock\Domain\Options\ScenarioState
     */
    private function getNewScenarioState(array $expectationArray)
    {
        $newScenarioState = null;
        if (!empty($expectationArray['newScenarioState'])) {
            $newScenarioState = new ScenarioState($expectationArray['newScenarioState']);
        }

        return $newScenarioState;
    }

    /**
     * @param array $expectationArray
     *
     * @return Response
     */
    private function convertResponse(array $expectationArray)
    {
        if (isset($expectationArray['response'])) {
            return $this->arrayToResponseConverter->convert(
                $expectationArray['response'],
                $this->getNewScenarioState($expectationArray)
            );
        }

        if (!empty($expectationArray['proxyTo'])) {
            return new ProxyResponse(
                new Uri($expectationArray['proxyTo']),
                $this->getNewScenarioState($expectationArray)
            );
        }
        throw new \InvalidArgumentException('Creating an expectation without response. One of response or proxyTo are needed');
    }

    private function convertRequest(array $expectationArray)
    {
        if (!isset($expectationArray['request'])) {
            throw new \InvalidArgumentException('Expectation request is not set');
        }

        return $this->arrayToRequestConverter->convert($expectationArray['request']);
    }
}
