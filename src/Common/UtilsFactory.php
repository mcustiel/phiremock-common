<?php

namespace Mcustiel\Phiremock\Common;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToScenarioStateInfoConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\ScenarioStateInfoToArrayConverter;

interface UtilsFactory
{
    public function createArrayToExpectationConverter(): ArrayToExpectationConverter;

    public function createArrayToStateConditionsConverter(): ArrayToStateConditionsConverter;

    public function createArrayToRequestConditionConverter(): ArrayToRequestConditionConverter;

    public function createExpectationToArrayConverter(): ExpectationToArrayConverter;

    public function createRequestConditionToArrayConverter(): RequestConditionToArrayConverter;

    public function createArrayToScenarioStateInfoConverter(): ArrayToScenarioStateInfoConverter;

    public function createScenarioStateInfoToArrayConverter(): ScenarioStateInfoToArrayConverter;

    public function createArrayToHttpResponseConverter(): ArrayToResponseConverter;

    public function createArrayToProxyResponseConverter(): ArrayToResponseConverter;

    public function createHttpResponseToArrayConverter(): ResponseToArrayConverter;

    public function createProxyResponseToArrayConverter(): ResponseToArrayConverter;
}
