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

use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderCondition;
use Mcustiel\Phiremock\Domain\Conditions;
use Mcustiel\Phiremock\Domain\Http\HeaderName;

class RequestConditionToArrayConverter
{
    public function convert(Conditions $request): array
    {
        $requestArray = [];

        $this->convertMethod($request, $requestArray);
        $this->convertUrl($request, $requestArray);
        $this->convertBody($request, $requestArray);
        $this->convertHeaders($request, $requestArray);

        return $requestArray;
    }

    protected function convertHeaders(Conditions $request, array &$requestArray): void
    {
        $headers = $request->getHeaders();
        if ($headers === null) {
            $requestArray['headers'] = null;
        } else {
            $headersArray = [];
            /** @var HeaderName $headerName */
            /** @var HeaderCondition $headerCondition */
            foreach ($headers as $headerName => $headerCondition) {
                $headersArray[$headerName->asString()] = [
                    $headerCondition->getMatcher()->getName() => $headerCondition->getValue()->asString(),
                ];
            }
            $requestArray['headers'] = $headersArray;
        }
    }

    protected function convertBody(Conditions $request, array &$requestArray): void
    {
        $body = $request->getBody();
        $requestArray['body'] = null === $body ? null : [
            $body->getMatcher()->getName() => $body->getValue()->asString(),
        ];
    }

    protected function convertUrl(Conditions $request, array &$requestArray): void
    {
        $url = $request->getUrl();
        $requestArray['url'] = null === $url ? null : [
            $url->getMatcher()->getName() => $url->getValue()->asString(),
        ];
    }

    protected function convertMethod(Conditions $request, array &$requestArray): void
    {
        $method = $request->getMethod();
        $requestArray['method'] = null === $method ? null : $method->getValue()->asString();
    }
}
