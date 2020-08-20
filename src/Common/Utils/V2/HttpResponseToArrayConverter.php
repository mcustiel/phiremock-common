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

use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Domain\Http\Header;

class HttpResponseToArrayConverter extends ResponseToArrayConverter
{
    public function convert(Response $response): array
    {
        /** @var HttpResponse $response */
        $responseArray = [];
        $responseArray['statusCode'] = $response->getStatusCode()->asInt();
        $body = $response->getBody();
        $responseArray['body'] = $body === null ? null : $body->asString();
        $headers = $response->getHeaders();
        if ($headers && !$headers->isEmpty()) {
            $responseArray['headers'] = $this->convertHeaders($response);
        } else {
            $responseArray['headers'] = null;
        }

        return array_merge(parent::convert($response), ['response' => $responseArray]);
    }

    private function convertHeaders(HttpResponse $response): array
    {
        $headers = $response->getHeaders();
        $headersArray = [];
        /** @var Header $header */
        foreach ($headers as $header) {
            $headersArray[$header->getName()->asString()] = $header->getValue()->asString();
        }

        return $headersArray;
    }
}
