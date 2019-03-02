<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;

class ExpectationToArrayConverter
{
    /** @var RequestToArrayConverter */
    private $requestToArrayConverter;

    /** @var ResponseToArrayConverter */
    private $responseToArrayConverter;

    public function __construct(
        RequestToArrayConverter $requestConverter,
        ResponseToArrayConverter $responseConverter
    ) {
        $this->requestToArrayConverter = $requestConverter;
        $this->responseToArrayConverter = $responseConverter;
    }

    public function convert(Expectation $expectation)
    {
        $expectationArray = [];

        $expectationArray['request'] = $this->requestToArrayConverter->convert($expectation->getRequest());
        if (null !== $expectation->getResponse()) {
            $expectationArray['response'] = $this->responseToArrayConverter->convert($expectation->getResponse());
        }
        if ($expectation->getPriority()->asInt() > 0) {
            $expectationArray['priority'] = $expectation->getPriority()->asInt();
        }
        if (null !== $expectation->getNewScenarioState()) {
            $expectationArray['newScenarioState'] = $expectation->getNewScenarioState()->asString();
        }
        if (null !== $expectation->getScenarioStateIs()) {
            $expectationArray['scenarioStateIs'] = $expectation->getScenarioStateIs()->asString();
        }
        if (null !== $expectation->getScenarioName()) {
            $expectationArray['scenarioName'] = $expectation->getScenarioName()->asString();
        }
        if (null !== $expectation->getProxyTo()) {
            $expectationArray['proxyTo'] = $expectation->getProxyTo()->asString();
        }

        return $expectationArray;
    }
}
