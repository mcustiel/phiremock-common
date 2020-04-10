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
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class HttpResponse extends Response
{
    /** @var StatusCode */
    private $statusCode;

    /** @var Body */
    private $body;

    /** @var HeadersCollection */
    private $headers;

    public function __construct(
        StatusCode $statusCode = null,
        ?Body $body = null,
        ?HeadersCollection $headers = null,
        ?Delay $delayMillis = null,
        ?ScenarioState $newScenarioState = null
    ) {
        parent::__construct($delayMillis, $newScenarioState);
        $this->statusCode = $statusCode ?? StatusCode::createDefault();
        $this->headers = $headers;
        $this->body = $body;
    }

    /** @return self */
    public static function createEmpty()
    {
        return new self(
            new StatusCode(200),
            new Body(''),
            new HeadersCollection()
        );
    }

    /** @return StatusCode */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /** @return Body */
    public function getBody()
    {
        return $this->body;
    }

    /** @return HeadersCollection */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Domain\Response::isHttpResponse()
     */
    public function isHttpResponse()
    {
        return true;
    }
}
