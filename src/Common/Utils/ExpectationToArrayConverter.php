<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\MockConfig;

class ExpectationToArrayConverter
{
    /** @var RequestConditionToArrayConverter */
    private $requestToArrayConverter;

    /** @var ResponseToArrayConverter */
    private $responseToArrayConverter;

    public function __construct(
        RequestConditionToArrayConverter $requestConverter,
        ResponseToArrayConverter $responseConverter
    ) {
        $this->requestToArrayConverter = $requestConverter;
        $this->responseToArrayConverter = $responseConverter;
    }

    public function convert(MockConfig $expectation)
    {
        $expectationArray = [];

        $expectationArray['request'] = $this->requestToArrayConverter->convert($expectation->getRequest());
        if ($expectation->getResponse()->isHttpResponse()) {
            $expectationArray['response'] = $this->responseToArrayConverter->convert($expectation->getResponse());
        } else {
            $expectationArray['proxyTo'] = $this->responseToArrayConverter->convert($expectation->getResponse());
        }
        if ($expectation->getPriority()->asInt() > 0) {
            $expectationArray['priority'] = $expectation->getPriority()->asInt();
        }
        if (null !== $expectation->getResponse()->getNewScenarioState()) {
            $expectationArray['newScenarioState'] = $expectation->getResponse()->getNewScenarioState()->asString();
        }
        if (null !== $expectation->getStateConditions()->getScenarioStateIs()) {
            $expectationArray['scenarioStateIs'] = $expectation->getStateConditions()->getScenarioStateIs()->asString();
        }
        if (null !== $expectation->getStateConditions()->getScenarioName()) {
            $expectationArray['scenarioName'] = $expectation->getStateConditions()->getScenarioName()->asString();
        }

        return $expectationArray;
    }
}
