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

use Mcustiel\Phiremock\Domain\Conditions\Body\BodyCondition;
use Mcustiel\Phiremock\Domain\Conditions\Header\HeaderConditionCollection;
use Mcustiel\Phiremock\Domain\Conditions\Method\MethodCondition;
use Mcustiel\Phiremock\Domain\Conditions\Url\UrlCondition;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class RequestConditions
{
    /** @var MethodCondition */
    private $method;
    /** @var UrlCondition */
    private $url;
    /** @var BodyCondition */
    private $body;
    /** @var HeaderConditionCollection */
    private $headers;
    /** @var ScenarioState */
    private $scenarioState;

    public function __construct(
        MethodCondition $method,
        UrlCondition $url = null,
        BodyCondition $body = null,
        HeaderConditionCollection $headers = null,
        ScenarioState $scenarioState = null
    ) {
        $this->method = $method;
        $this->url = $url;
        $this->body = $body;
        $this->headers = null !== $headers ? $headers : new HeaderConditionCollection();
        $this->scenarioState = $scenarioState;
    }

    /** @return MethodCondition */
    public function getMethod()
    {
        return $this->method;
    }

    /** @return bool */
    public function hasUrl()
    {
        return null !== $this->url;
    }

    /** @return UrlCondition|null */
    public function getUrl()
    {
        return $this->url;
    }

    /** @return bool */
    public function hasBody()
    {
        return null !== $this->body;
    }

    /** @return BodyCondition|null */
    public function getBody()
    {
        return $this->body;
    }

    /** @return HeaderConditionCollection */
    public function getHeaders()
    {
        return $this->headers;
    }

    /** @return bool */
    public function hasScenarioState()
    {
        return $this->scenarioState !== null;
    }

    /** @return ScenarioState|null */
    public function getScenarioState()
    {
        return $this->scenarioState;
    }
}
