<?php

namespace Mcustiel\Phiremock\Common\Utils\V2;

use Mcustiel\Phiremock\Common\Utils\V1\Factory as FactoryV1;

class Factory extends FactoryV1
{
    public function createArrayToExpectationConverter(): ArrayToExpectationConverter
    {
        return new ArrayToExpectationConverter(
            $this->createArrayToRequestConditionConverter(),
            $this->createArrayToResponseConverterLocator()
        );
    }

    public function createArrayToStateConditionsConverter(): ArrayToStateConditionsConverter
    {
        return new ArrayToStateConditionsConverter();
    }

    public function createArrayToResponseConverterLocator(): ArrayToResponseConverterLocator
    {
        return new ArrayToResponseConverterLocator($this);
    }

    public function createArrayToHttpResponseConverter(): ArrayToHttpResponseConverter
    {
        return new ArrayToHttpResponseConverter();
    }

    public function createArrayToProxyResponseConverter(): ArrayToProxyResponseConverter
    {
        return new ArrayToProxyResponseConverter();
    }

    public function createArrayToRequestConditionConverter(): ArrayToRequestConditionConverter
    {
        return new ArrayToRequestConditionConverter();
    }

    public function createExpectationToArrayConverter(): ExpectationToArrayConverter
    {
        return new ExpectationToArrayConverter(
            $this->createRequestConditionToArrayConverter(),
            $this->createResponseToArrayConverterLocator()
        );
    }

    public function createHttpResponseToArrayConverter(): HttpResponseToArrayConverter
    {
        return new HttpResponseToArrayConverter();
    }

    public function createProxyResponseToArrayConverter(): ProxyResponseToArrayConverter
    {
        return new ProxyResponseToArrayConverter();
    }

    public function createResponseToArrayConverterLocator(): ResponseToArrayConverterLocator
    {
        return new ResponseToArrayConverterLocator($this);
    }

    public function createRequestConditionToArrayConverter(): RequestConditionToArrayConverter
    {
        return new RequestConditionToArrayConverter();
    }

    public function createArrayToScenarioStateInfoConverter(): ArrayToScenarioStateInfoConverter
    {
        return new ArrayToScenarioStateInfoConverter();
    }

    public function createScenarioStateInfoToArrayConverter(): ScenarioStateInfoToArrayConverter
    {
        return new ScenarioStateInfoToArrayConverter();
    }
}
