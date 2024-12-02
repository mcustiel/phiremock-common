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

use Mcustiel\Phiremock\Domain\Condition\Conditions\BodyCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\FormFieldConditionIterator;
use Mcustiel\Phiremock\Domain\Condition\Conditions\HeaderConditionIterator;
use Mcustiel\Phiremock\Domain\Condition\Conditions\JsonPathConditionIterator;
use Mcustiel\Phiremock\Domain\Condition\Conditions\MethodCondition;
use Mcustiel\Phiremock\Domain\Condition\Conditions\UrlCondition;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class Conditions
{
    /** @var MethodCondition|null */
    private $method;
    /** @var UrlCondition|null */
    private $url;
    /** @var BodyCondition|null */
    private $body;
    /** @var HeaderConditionIterator|null */
    private $headers;
    /** @var FormFieldConditionIterator|null */
    private $formFields;
    /** @var ScenarioState|null */
    private $scenarioState;
    /** @var JsonPathConditionIterator|null */
    private $jsonPath;

    public function __construct(
        ?MethodCondition $method = null,
        ?UrlCondition $url = null,
        ?BodyCondition $body = null,
        ?HeaderConditionIterator $headers = null,
        ?FormFieldConditionIterator $formFields = null,
        ?ScenarioState $scenarioState = null,
        ?JsonPathConditionIterator $jsonPath = null
    ) {
        $this->method = $method;
        $this->url = $url;
        $this->body = $body;
        $this->headers = $headers;
        $this->formFields = $formFields;
        $this->scenarioState = $scenarioState;
        $this->jsonPath = $jsonPath;
    }

    public function hasMethod(): bool
    {
        return null !== $this->method;
    }

    public function getMethod(): ?MethodCondition
    {
        return $this->method;
    }

    public function hasUrl(): bool
    {
        return null !== $this->url;
    }

    public function getUrl(): ?UrlCondition
    {
        return $this->url;
    }

    public function hasBody(): bool
    {
        return null !== $this->body;
    }

    public function getBody(): ?BodyCondition
    {
        return $this->body;
    }

    public function hasHeaders(): bool
    {
        return null !== $this->headers && !$this->headers->isEmpty();
    }

    public function getHeaders(): ?HeaderConditionIterator
    {
        return $this->headers;
    }

    public function hasFormFields(): bool
    {
        return null !== $this->formFields && !$this->formFields->isEmpty();
    }

    public function getFormFields(): ?FormFieldConditionIterator
    {
        return $this->formFields;
    }

    public function hasScenarioState(): bool
    {
        return $this->scenarioState !== null;
    }

    public function getScenarioState(): ?ScenarioState
    {
        return $this->scenarioState;
    }

    public function hasJsonPath(): bool 
    {
        return null !== $this->jsonPath;
    }

    public function getJsonPath(): ?JsonPathConditionIterator
    {
        return $this->jsonPath;
    }
}
