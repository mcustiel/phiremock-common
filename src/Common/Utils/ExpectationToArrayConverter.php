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

        $expectationArray['request'] = $this->requestToArrayConverter->convert($expectation->getRequest());
        $expectationArray['response'] = $this->responseConverterLocator
            ->locate($expectation->getResponse())
            ->convert($expectation->getResponse());
        if ($expectation->hasScenarioName()) {
            $expectationArray['scenarioName'] = $expectation->getScenarioName()->asString();
        }
        if ($expectation->hasPriority()) {
            $expectationArray['priority'] = $expectation->getPriority()->asInt();
        }

        return $expectationArray;
    }
}
