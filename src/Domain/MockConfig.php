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

class MockConfig
{
    /** @var RequestConditions */
    private $requestConditions;

    /** @var StateConditions */
    private $stateConditions;

    /** @var Response */
    private $response;

    /** @var Priority */
    private $priority;

    public function __construct(
        RequestConditions $requestConditions = null,
        StateConditions $stateconditions = null,
        Response $response = null,
        Priority $priority = null
    ) {
        $this->priority = null !== $priority ? $priority : Priority::createDefault();
        $this->requestConditions = null !== $requestConditions ? $requestConditions : new RequestConditions();
        $this->stateConditions = null !== $stateconditions ? $stateconditions : new StateConditions();
        $this->response = null !== $response ? $response : new HttpResponse();
    }

    /** @return \Mcustiel\Phiremock\Domain\RequestConditions */
    public function getRequest()
    {
        return $this->requestConditions;
    }

    /** @return \Mcustiel\Phiremock\Domain\StateConditions */
    public function getStateConditions()
    {
        return $this->stateConditions;
    }

    /** @return \Mcustiel\Phiremock\Domain\Response */
    public function getResponse()
    {
        return $this->response;
    }

    /** @return bool */
    public function hasPriority()
    {
        return null !== $this->priority;
    }

    /** @return Priority|null */
    public function getPriority()
    {
        return $this->priority;
    }
}
