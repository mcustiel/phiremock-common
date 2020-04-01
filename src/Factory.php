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
use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToProxyResponseConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\V2\ArrayToRequestConditionConverter as ArrayToRequestConditionConverterV2;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ArrayToScenarioStateInfoConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\HttpResponseToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\ProxyResponseToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ArrayToConditionsConverterLocator;

class Factory
{
    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter */
    public function createArrayToExpectationConverter()
    {
        return new ArrayToExpectationConverter(
            $this->createArrayToConditionsConverterLocator(),
            $this->createArrayToResponseConverterLocator(),
            $this->createArrayToStateConditionsConverter()
        );
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter */
    public function createArrayToStateConditionsConverter()
    {
        return new ArrayToStateConditionsConverter();
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator */
    public function createArrayToResponseConverterLocator()
    {
        return new ArrayToResponseConverterLocator($this);
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator */
    public function createArrayToConditionsConverterLocator()
    {
        return new ArrayToConditionsConverterLocator($this);
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToHttpResponseConverter */
    public function createArrayToHttpResponseConverter()
    {
        return new ArrayToHttpResponseConverter();
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToProxyResponseConverter*/
    public function createArrayToProxyResponseConverter()
    {
        return new ArrayToProxyResponseConverter();
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter */
    public function createArrayToRequestConditionConverter()
    {
        return new ArrayToRequestConditionConverter();
    }

    public function createArrayToRequestConditionV2Converter()
    {
        return new ArrayToRequestConditionConverterV2();
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter */
    public function createExpectationToArrayConverter()
    {
        return new ExpectationToArrayConverter(
            $this->createRequestConditionToArrayConverter(),
            $this->createResponseToArrayConverterLocator()
        );
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\HttpResponseToArrayConverter */
    public function createHttpResponseToArrayConverter()
    {
        return new HttpResponseToArrayConverter();
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ProxyResponseToArrayConverter */
    public function createProxyResponseToArrayConverter()
    {
        return new ProxyResponseToArrayConverter();
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverterLocator */
    public function createResponseToArrayConverterLocator()
    {
        return new ResponseToArrayConverterLocator($this);
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter */
    public function createRequestConditionToArrayConverter()
    {
        return new RequestConditionToArrayConverter();
    }

    /** @return \Mcustiel\Phiremock\Common\Http\Implementation\GuzzleConnection */
    public function createRemoteConnectionInterface()
    {
        return new GuzzleConnection(new \GuzzleHttp\Client());
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToScenarioStateInfoConverter */
    public function createArrayToScenarioStateInfoConverter()
    {
        return new ArrayToScenarioStateInfoConverter();
    }
}
