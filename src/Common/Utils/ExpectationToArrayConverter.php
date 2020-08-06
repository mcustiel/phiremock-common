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

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;

class ExpectationToArrayConverter
{
    /** @var RequestConditionToArrayConverterLocator */
    private $requestToArrayConverterLocator;

    /** @var ResponseToArrayConverterLocator */
    private $responseConverterLocator;

    public function __construct(
        RequestConditionToArrayConverterLocator $requestConverterLocator,
        ResponseToArrayConverterLocator $responseConverterLocator
    ) {
        $this->requestToArrayConverterLocator = $requestConverterLocator;
        $this->responseConverterLocator = $responseConverterLocator;
    }

    public function convert(Expectation $expectation)
    {
        $expectationArray = [];

        if ($expectation->getVersion()->asString() !== '1') {
            $expectationArray['version'] = $expectation->getVersion()->asString();
        }

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

        $expectationArray['request'] = $this->requestToArrayConverterLocator
            ->locate($expectation)
            ->convert($expectation->getRequest());

        $response = $expectation->getResponse();

        if ($response->isHttpResponse()) {
            /* @var \Mcustiel\Phiremock\Domain\HttpResponse $response */
            $expectationArray['response'] = $this->responseConverterLocator
                ->locate($response)
                ->convert($response);
            $expectationArray['proxyTo'] = null;
        } else {
            /* @var \Mcustiel\Phiremock\Domain\ProxyResponse $response */
            $expectationArray['response'] = null;
            $expectationArray['proxyTo'] = $response->getUri()->asString();
        }

        if ($expectation->hasPriority()) {
            $expectationArray['priority'] = $expectation->getPriority()->asInt();
        } else {
            $expectationArray['priority'] = 0;
        }

        return $expectationArray;
    }
}
