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

namespace Mcustiel\Phiremock\Domain;

use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\Options\Delay;

class HttpResponse extends Response
{
    /** @var StatusCode */
    private $statusCode;

    /** @var Body */
    private $body;

    /** @var HeadersCollection */
    private $headers;

    /** @var Delay */
    private $delayMillis;

    public function __construct(
        StatusCode $statusCode = null,
        Body $body = null,
        HeadersCollection $headers = null,
        Delay $delayMillis = null
    ) {
        $this->statusCode = null !== $statusCode ? $statusCode : StatusCode::createDefault();
        $this->headers = null !== $headers ? $headers : new HeadersCollection();
        $this->delayMillis = null !== $delayMillis ? $delayMillis : Delay::createDefault();
        $this->body = null !== $body ? $body : Body::createEmpty();
    }

    /**
     * @return StatusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param StatusCode $statusCode
     *
     * @return self
     */
    public function setStatusCode(StatusCode $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return Body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param Body $body
     *
     * @return self
     */
    public function setBody(Body $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return HeadersCollection
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return Delay
     */
    public function getDelayMillis()
    {
        return $this->delayMillis;
    }

    /**
     * @param Delay $delayMillis
     *
     * @return self
     */
    public function setDelayMillis(Delay $delayMillis)
    {
        $this->delayMillis = $delayMillis;

        return $this;
    }

    public function isHttpResponse()
    {
        return true;
    }
}
