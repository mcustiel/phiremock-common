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

use Mcustiel\Phiremock\Domain\Http\Uri;
use Mcustiel\Phiremock\Domain\Options\Priority;
use Mcustiel\Phiremock\Domain\Options\ScenarioName;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class Expectation implements \JsonSerializable
{
    /** @var Request */
    private $request;

    /** @var Response */
    private $response;

    /** @var Uri */
    private $proxyTo;

    /** @var ScenarioName */
    private $scenarioName;

    /** @var ScenarioState */
    private $scenarioStateIs;

    /** @var ScenarioState */
    private $newScenarioState;

    /** @var Priority */
    private $priority;

    public function __construct()
    {
        $this->priority = Priority::createDefault();
        $this->request = new Request();
    }

    public function __toString()
    {
        return print_r(
            [
                'scenarioName'     => isset($this->scenarioName) ? $this->scenarioName->asString() : 'null',
                'scenarioStateIs'  => isset($this->scenarioStateIs) ? $this->scenarioStateIs->asString() : 'null',
                'newScenarioState' => isset($this->newScenarioState) ? $this->newScenarioState->asString() : 'null',
                'request'          => isset($this->request) ? $this->request->__toString() : 'null',
                'response'         => isset($this->response) ? $this->response->__toString() : 'null',
                'proxyTo'          => isset($this->proxyTo) ? $this->proxyTo->asString() : 'null',
                'priority'         => isset($this->priority) ? $this->priority->asString() : 'null',
            ], true
        );
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Request $request
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Response $response
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return ScenarioName|null
     */
    public function getScenarioName()
    {
        return $this->scenarioName;
    }

    /**
     * @param ScenarioName $scenario
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setScenarioName(ScenarioName $scenario)
    {
        $this->scenarioName = $scenario;

        return $this;
    }

    /**
     * @return ScenarioState|null
     */
    public function getScenarioStateIs()
    {
        return $this->scenarioStateIs;
    }

    /**
     * @param ScenarioState $scenarioStateIs
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setScenarioStateIs(ScenarioState $scenarioStateIs)
    {
        $this->scenarioStateIs = $scenarioStateIs;

        return $this;
    }

    /**
     * @return ScenarioState|null
     */
    public function getNewScenarioState()
    {
        return $this->newScenarioState;
    }

    /**
     * @param ScenarioState $newScenarioState
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setNewScenarioState(ScenarioState $newScenarioState)
    {
        $this->newScenarioState = $newScenarioState;

        return $this;
    }

    /**
     * @return Priority|null
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param Priority $priority
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setPriority(Priority $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return Uri|null
     */
    public function getProxyTo()
    {
        return $this->proxyTo;
    }

    /**
     * @param Uri $proxyTo
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setProxyTo(Uri $proxyTo)
    {
        $this->proxyTo = $proxyTo;

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
            'scenarioName'     => $this->scenarioName,
            'scenarioStateIs'  => $this->scenarioStateIs,
            'newScenarioState' => $this->newScenarioState,
            'request'          => $this->request,
            'response'         => $this->response,
            'proxyTo'          => $this->proxyTo,
            'priority'         => $this->priority,
        ];
    }
}
