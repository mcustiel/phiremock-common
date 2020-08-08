<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mcustiel\Phiremock;

use Mcustiel\Phiremock\Common\Http\Implementation\GuzzleConnection;
use Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface;
use Mcustiel\Phiremock\Common\Utils\ArrayToConditionsConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToProxyResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ArrayToScenarioStateInfoConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\HttpResponseToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\ProxyResponseToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ScenarioStateInfoToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\V2\ArrayToRequestConditionConverter as ArrayToRequestConditionConverterV2;
use Mcustiel\Phiremock\Common\Utils\V2\RequestConditionToArrayConverter as RequestConditionToArrayConverterV2;

class Factory
{
    public function createArrayToExpectationConverter(): ArrayToExpectationConverter
    {
        return new ArrayToExpectationConverter(
            $this->createArrayToConditionsConverterLocator(),
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

    public function createArrayToConditionsConverterLocator(): ArrayToConditionsConverterLocator
    {
        return new ArrayToConditionsConverterLocator($this);
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

    public function createArrayToRequestConditionV2Converter(): ArrayToRequestConditionConverterV2
    {
        return new ArrayToRequestConditionConverterV2();
    }

    public function createExpectationToArrayConverter(): ExpectationToArrayConverter
    {
        return new ExpectationToArrayConverter(
            $this->createRequestConditionToArrayConverterLocator(),
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

    public function createRequestConditionToArrayConverterLocator(): RequestConditionToArrayConverterLocator
    {
        return new RequestConditionToArrayConverterLocator($this);
    }

    public function createRequestConditionToArrayConverter(): RequestConditionToArrayConverter
    {
        return new RequestConditionToArrayConverter();
    }

    public function createRequestConditionToArrayV2Converter(): RequestConditionToArrayConverterV2
    {
        return new RequestConditionToArrayConverterV2();
    }

    public function createRemoteConnectionInterface(): RemoteConnectionInterface
    {
        return new GuzzleConnection(new \GuzzleHttp\Client());
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
