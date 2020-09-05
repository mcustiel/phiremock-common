<?php

namespace Mcustiel\Phiremock\Common\Utils\V2;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter as ArrayToExpectationConverterInterface;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter as ArrayToRequestConditionConverterInterface;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverter as ArrayToResponseConverterInterface;
use Mcustiel\Phiremock\Common\Utils\ArrayToScenarioStateInfoConverter as ArrayToScenarioStateInfoConverterInterface;
use Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter as ArrayToStateConditionsConverterInterface;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter as ExpectationToArrayConverterInterface;
use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter as RequestConditionToArrayConverterInterface;
use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverter as ResponseToArrayConverterInterface;
use Mcustiel\Phiremock\Common\Utils\ScenarioStateInfoToArrayConverter as ScenarioStateInfoToArrayConverterInterface;
use Mcustiel\Phiremock\Common\UtilsFactory;

class Factory implements UtilsFactory
{
    public function createArrayToExpectationConverter(): ArrayToExpectationConverterInterface
    {
        return new ArrayToExpectationConverter(
            $this->createArrayToRequestConditionConverter(),
            $this->createArrayToResponseConverterLocator()
        );
    }

    public function createArrayToStateConditionsConverter(): ArrayToStateConditionsConverterInterface
    {
        return new ArrayToStateConditionsConverter();
    }

    public function createArrayToResponseConverterLocator(): ArrayToResponseConverterLocator
    {
        return new ArrayToResponseConverterLocator($this);
    }

    public function createArrayToHttpResponseConverter(): ArrayToResponseConverterInterface
    {
        return new ArrayToHttpResponseConverter();
    }

    public function createArrayToProxyResponseConverter(): ArrayToResponseConverterInterface
    {
        return new ArrayToProxyResponseConverter();
    }

    public function createArrayToRequestConditionConverter(): ArrayToRequestConditionConverterInterface
    {
        return new ArrayToRequestConditionConverter();
    }

    public function createExpectationToArrayConverter(): ExpectationToArrayConverterInterface
    {
        return new ExpectationToArrayConverter(
            $this->createRequestConditionToArrayConverter(),
            $this->createResponseToArrayConverterLocator()
        );
    }

    public function createHttpResponseToArrayConverter(): ResponseToArrayConverterInterface
    {
        return new HttpResponseToArrayConverter();
    }

    public function createProxyResponseToArrayConverter(): ResponseToArrayConverterInterface
    {
        return new ProxyResponseToArrayConverter();
    }

    public function createResponseToArrayConverterLocator(): ResponseToArrayConverterLocator
    {
        return new ResponseToArrayConverterLocator($this);
    }

    public function createRequestConditionToArrayConverter(): RequestConditionToArrayConverterInterface
    {
        return new RequestConditionToArrayConverter();
    }

    public function createArrayToScenarioStateInfoConverter(): ArrayToScenarioStateInfoConverterInterface
    {
        return new ArrayToScenarioStateInfoConverter();
    }

    public function createScenarioStateInfoToArrayConverter(): ScenarioStateInfoToArrayConverterInterface
    {
        return new ScenarioStateInfoToArrayConverter();
    }
}
