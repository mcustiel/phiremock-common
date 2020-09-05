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

use Mcustiel\Phiremock\Common\Utils\BodyHelper;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\HttpResponse;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Response;

class ArrayToHttpResponseConverter extends ArrayToResponseConverter
{
    const ALLOWED_OPTIONS = [
        'statusCode' => null,
        'body'       => null,
        'headers'    => null,
        'delayMillis'=> null,
    ];
    const STRING_START = 0;

    protected function convertResponse(
        array $responseArray,
        ?Delay $delay,
        ?ScenarioState $newScenarioState
    ): Response {
        if (!isset($responseArray['response']['statusCode'])) {
            $responseArray['response']['statusCode'] = 200;
        }

        return new HttpResponse(
            new StatusCode((int) $responseArray['response']['statusCode']),
            $this->getBody($responseArray['response']),
            $this->getHeaders($responseArray['response']),
            $delay,
            $newScenarioState
        );
    }

    private function getHeaders(array $responseArray): ?HeadersCollection
    {
        if (isset($responseArray['headers'])) {
            $headers = $responseArray['headers'];
            if (!empty($headers)) {
                if (!\is_array($headers)) {
                    throw new \InvalidArgumentException('Response headers are invalid: ' . var_export($headers, true));
                }

                return $this->convertHeaders($headers);
            }
        }

        return null;
    }

    private function getBody(array $responseArray): ?Body
    {
        if (isset($responseArray['body'])) {
            $body = $responseArray['body'];
            if (\is_array($body)) {
                $body = json_encode($body);
            }

            return BodyHelper::getBodyObject($body);
        }

        return null;
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function convertHeaders(array $headers): HeadersCollection
    {
        $headerCollection = new HeadersCollection();
        foreach ($headers as $headerName => $headerValue) {
            $headerCollection->setHeader(
                new Header(
                    new HeaderName($headerName),
                    new HeaderValue($headerValue)
                )
            );
        }

        return $headerCollection;
    }
}
