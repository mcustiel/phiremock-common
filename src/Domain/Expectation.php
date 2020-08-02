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

use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;

class Expectation
{
    /** @var Conditions */
    private $requestConditions;

    /** @var ScenarioName */
    private $scenarioName;

    /** @var Response */
    private $response;

    /** @var Priority */
    private $priority;

    /** @var Version */
    private $version;

    public function __construct(
        Conditions $requestConditions,
        Response $response,
        ScenarioName $scenarioName = null,
        Priority $priority = null,
        Version $version = null
    ) {
        $this->priority = $priority;
        $this->requestConditions = $requestConditions;
        $this->scenarioName = $scenarioName;
        $this->response = $response;
        $this->version = $version ?? new Version(1);
    }

    public function getVersion(): Version
    {
        return $this->version;
    }

    public function getRequest(): Conditions
    {
        return $this->requestConditions;
    }

    public function hasScenarioName(): bool
    {
        return $this->scenarioName !== null;
    }

    public function getScenarioName(): ?ScenarioName
    {
        return $this->scenarioName;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function hasPriority(): bool
    {
        return null !== $this->priority;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(Priority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
