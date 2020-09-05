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

namespace Mcustiel\Phiremock\Common\Utils\V1;

use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverter as ExpectationToArrayConverterInterface;
use Mcustiel\Phiremock\Domain\Expectation;

class ExpectationToArrayConverter implements ExpectationToArrayConverterInterface
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

    public function convert(Expectation $expectation): array
    {
        $expectationArray = [];

        if ($expectation->getVersion()->asString() !== '1') {
            $expectationArray['version'] = $expectation->getVersion()->asString();
        }

        $expectationArray['scenarioName'] = $this->getScenarioName($expectation);
        $expectationArray['scenarioStateIs'] = $this->getScenarioState($expectation);
        $expectationArray['newScenarioState'] = $this->getNewScenarioState($expectation);
        $expectationArray['request'] = $this->requestToArrayConverter->convert($expectation->getRequest());

        $this->setResponse($expectation, $expectationArray);

        $expectationArray['priority'] = $this->getPriority($expectation);

        return $expectationArray;
    }

    private function setResponse(Expectation $expectation, array &$expectationArray): void
    {
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
    }

    private function getScenarioName(Expectation $expectation): ?string
    {
        if ($expectation->hasScenarioName()) {
            return $expectation->getScenarioName()->asString();
        }

        return null;
    }

    private function getScenarioState(Expectation $expectation): ?string
    {
        if ($expectation->getRequest()->hasScenarioState()) {
            return $expectation->getRequest()->getScenarioState()->asString();
        }

        return null;
    }

    private function getNewScenarioState(Expectation $expectation): ?string
    {
        if ($expectation->getResponse()->hasNewScenarioState()) {
            return $expectation->getResponse()->getNewScenarioState()->asString();
        }

        return null;
    }

    private function getPriority(Expectation $expectation): int
    {
        if ($expectation->hasPriority()) {
            return $expectation->getPriority()->asInt();
        }

        return 0;
    }
}
