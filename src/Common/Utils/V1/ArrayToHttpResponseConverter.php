<?php

declare(strict_types=1);

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

use Mcustiel\Phiremock\Common\Utils\HttpResponseArrayParsing;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Response;

class ArrayToHttpResponseConverter extends ArrayToResponseConverter
{
    use HttpResponseArrayParsing;

    public const ALLOWED_OPTIONS = [
        'statusCode' => null,
        'body' => null,
        'headers' => null,
        'delayMillis' => null,
    ];
    public const STRING_START = 0;

    protected function convertResponse(
        array $responseArray,
        ?Delay $delay,
        ?ScenarioState $newScenarioState
    ): Response {
        if (!isset($responseArray['response']['statusCode'])) {
            $responseArray['response']['statusCode'] = 200;
        }

        return new HttpResponse(
            $this->getStatusCode($responseArray['response']),
            $this->getBody($responseArray['response']),
            $this->getHeaders($responseArray['response']),
            $delay,
            $newScenarioState
        );
    }
}
