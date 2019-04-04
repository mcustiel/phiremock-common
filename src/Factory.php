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
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToScenarioStateInfoConverter;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToStateConditionsConverter;

class Factory
{
    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter */
    public function createArrayToExpectationConverter()
    {
        return new ArrayToExpectationConverter(
            new ArrayToRequestConditionConverter(),
            new ArrayToHttpResponseConverter(),
            new ArrayToStateConditionsConverter()
        );
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter */
    public function createExpectationToArrayConverter()
    {
        return new ExpectationToArrayConverter(
            new RequestConditionToArrayConverter(),
            new ResponseToArrayConverter()
        );
    }

    /** @return \Mcustiel\Phiremock\Common\Http\Implementation\GuzzleConnection */
    public function createRemoteConnectionInterface()
    {
        return new GuzzleConnection(new GuzzleHttp\Client());
    }

    /** @return \Mcustiel\Phiremock\Common\Utils\ArrayToScenarioStateInfoConverter */
    public function createArrayToScenarioStateInfoConverter()
    {
        return new ArrayToScenarioStateInfoConverter();
    }
}
