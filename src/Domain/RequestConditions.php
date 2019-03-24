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

use Mcustiel\Phiremock\Domain\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Http\Method;

class RequestConditions
{
    /**
     * @var Method
     */
    private $method;
    /**
     * @var UrlCondition
     */
    private $url;
    /**
     * @var BodyCondition
     */
    private $body;
    /**
     * @var HeaderConditionCollection
     */
    private $headers;

    public function __construct(
        Method $method = null,
        UrlCondition $url = null,
        BodyCondition $body = null,
        HeaderConditionCollection $headers = null
    ) {
        $this->method = null !== $method ? $method : Method::get();
        $this->headers = null !== $headers ? $headers : new HeaderConditionCollection();
        $this->body = $body;
        $this->url = $url;
    }

    /**
     * @return Method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param Method $method
     *
     * @return \Mcustiel\Phiremock\Domain\RequestConditions
     */
    public function setMethod(Method $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return UrlCondition|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param UrlCondition $url
     *
     * @return \Mcustiel\Phiremock\Domain\RequestConditions
     */
    public function setUrl(UrlCondition $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return BodyCondition|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param BodyCondition $body
     *
     * @return \Mcustiel\Phiremock\Domain\RequestConditions
     */
    public function setBody(BodyCondition $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return HeaderConditionCollection
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
