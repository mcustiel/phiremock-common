<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;

class ExpectationToArrayConverter
{
    /** @var RequestConditionToArrayConverter */
    private $requestToArrayConverter;

    /** @var ResponseToArrayConverterLocator */
    private $responseConverterLocator;

    public function __construct(
        RequestConditionToArrayConverter $requestConverter,
        ResponseToArrayConverterLocator $responseConverterLocator
    ) {
        $this->requestToArrayConverter = $requestConverter;
        $this->responseConverterLocator = $responseConverterLocator;
    }

    public function convert(Expectation $expectation)
    {
        $expectationArray = [];

        if ($expectation->hasScenarioName()) {
            $expectationArray['scenarioName'] = $expectation->getScenarioName()->asString();
        } else {
            $expectationArray['scenarioName'] = null;
        }
        if ($expectation->getRequest()->hasScenarioState()) {
            $expectationArray['scenarioStateIs'] = $expectation->getRequest()->getScenarioState()->asString();
        } else {
            $expectationArray['scenarioStateIs'] = null;
        }
        if ($expectation->getResponse()->hasNewScenarioState()) {
            $expectationArray['newScenarioState'] = $expectation->getResponse()->getNewScenarioState()->asString();
        } else {
            $expectationArray['newScenarioState'] = null;
        }

        $expectationArray['request'] = $this->requestToArrayConverter->convert($expectation->getRequest());

        $response = $expectation->getResponse();

        var_export('Let\'s convert the response');
        if ($response->isHttpResponse()) {
            $expectationArray['response'] = $this->responseConverterLocator
                ->locate($expectation->getResponse())
                ->convert($expectation->getResponse());
            $expectationArray['proxyTo'] = null;
        } else {
            $expectationArray['response'] = null;
            $expectationArray['proxyTo'] = $expectation->getResponse()->getUri()->asString();
        }

        if ($expectation->hasPriority()) {
            $expectationArray['priority'] = $expectation->getPriority()->asInt();
        } else {
            $expectationArray['priority'] = 0;
        }

        return $expectationArray;
    }
}
