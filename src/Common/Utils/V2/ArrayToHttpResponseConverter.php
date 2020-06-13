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

use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverter;
use Mcustiel\Phiremock\Domain\BinaryInfo;
use Mcustiel\Phiremock\Domain\Http\BinaryBody;
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
    const STRING_START = 0;

    protected function convertResponse(
        array $responseArray,
        Delay $delay = null,
        ScenarioState $newScenarioState = null
    ): Response {
        if (!isset($responseArray['statusCode'])) {
            $responseArray['statusCode'] = 200;
        }

        return new HttpResponse(
            new StatusCode((int) $responseArray['statusCode']),
            $this->getBody($responseArray),
            $this->getHeaders($responseArray),
            $delay,
            $newScenarioState
        );
    }

    /** @return \Mcustiel\Phiremock\Domain\Http\HeadersCollection */
    private function getHeaders($responseArray)
    {
        if (!empty($responseArray['headers'])) {
            return $this->convertHeaders($responseArray['headers']);
        }

        return new HeadersCollection();
    }

    /** @return \Mcustiel\Phiremock\Domain\Http\Body */
    private function getBody(array $responseArray)
    {
        if (isset($responseArray['body'])) {
            if ($this->isBinaryBody($responseArray['body'])) {
                return new BinaryBody($responseArray['body']);
            }

            return new Body($responseArray['body']);
        }

        return Body::createEmpty();
    }

    /**
     * @param string $body
     *
     * @return bool
     */
    private function isBinaryBody($body)
    {
        return BinaryInfo::BINARY_BODY_PREFIX === substr($body, self::STRING_START, BinaryInfo::BINARY_BODY_PREFIX_LENGTH);
    }

    /**
     * @param array $headers
     *
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\Phiremock\Domain\Http\HeadersCollection
     */
    private function convertHeaders($headers)
    {
        if (!\is_array($headers)) {
            throw new \InvalidArgumentException('Response headers are invalid: ' . var_export($headers, true));
        }

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
