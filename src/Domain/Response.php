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

class Response implements \JsonSerializable
{
    /** @var StatusCode */
    private $statusCode;

    /** @var Body */
    private $body;

    /** @var HeadersCollection */
    private $headers;

    /** @var Delay */
    private $delayMillis;

    public function __construct()
    {
        $this->statusCode = StatusCode::createDefault();
        $this->headers = new HeadersCollection();
        $this->delayMillis = Delay::createDefault();
        $this->body = Body::createEmpty();
    }

    public function __toString()
    {
        return print_r(
            [
                'statusCode'  => $this->statusCode->asInt(),
                'body'        => isset($this->body[5000]) ? '--VERY LONG CONTENTS--' : $this->body,
                'headers'     => $this->headers,
                'delayMillis' => isset($this->delayMillis) ? $this->delayMillis->asInt() : 'null',
            ],
            true
        );
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
     * @return \Mcustiel\Phiremock\Domain\Response
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
     * @return \Mcustiel\Phiremock\Domain\Response
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
     * @return \Mcustiel\Phiremock\Domain\Response
     */
    public function setDelayMillis(Delay $delayMillis)
    {
        $this->delayMillis = $delayMillis;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [
            'statusCode'  => $this->statusCode->asInt(),
            'body'        => $this->body->asString(),
            'headers'     => json_encode($this->headers),
            'delayMillis' => $this->delayMillis->asInt(),
        ];
    }
}
