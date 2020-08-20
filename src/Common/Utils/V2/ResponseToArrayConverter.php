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

use Mcustiel\Phiremock\Common\Utils\ResponseToArrayConverter as ResponseToArrayConverterInterface;
use Mcustiel\Phiremock\Common\Utils\V1\ResponseToArrayConverter as ResponseToArrayConverterV1;
use Mcustiel\Phiremock\Domain\Response;

class ResponseToArrayConverter implements ResponseToArrayConverterInterface
{
    public function convert(Response $response): array
    {
        $responseArray = [
            'delayMillis' => $response->hasDelayMillis()
                ? $response->getDelayMillis()->asInt()
                : null,
            'newScenarioState' => $response->hasNewScenarioState()
                ? $response->getNewScenarioState()->asString()
                : null,
        ];

        return $responseArray;
    }
}
