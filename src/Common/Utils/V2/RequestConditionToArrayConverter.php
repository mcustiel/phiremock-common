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

namespace Mcustiel\Phiremock\Common\Utils\V2;

use Mcustiel\Phiremock\Common\Utils\V1\RequestConditionToArrayConverter as RequestConditionToArrayConverterV1;
use Mcustiel\Phiremock\Domain\Conditions;

class RequestConditionToArrayConverter extends RequestConditionToArrayConverterV1
{
    public function convert(Conditions $request): array
    {
        $requestArray = [];

        $this->convertScenarioState($request, $requestArray);
        $this->convertMethod($request, $requestArray);
        $this->convertUrl($request, $requestArray);
        $this->convertBody($request, $requestArray);
        $this->convertHeaders($request, $requestArray);

        return $requestArray;
    }

    private function convertScenarioState(Conditions $request, array &$requestArray): void
    {
        $requestArray['scenarioStateIs'] = $request->hasScenarioState()
            ? $request->getScenarioState()->asString()
            : null;
    }

    protected function convertMethod(Conditions $request, array &$requestArray): void
    {
        $method = $request->getMethod();
        $requestArray['method'] = null === $method ? null : [
            $method->getMatcher()->getName() => $method->getValue()->asString(),
        ];
    }
}
