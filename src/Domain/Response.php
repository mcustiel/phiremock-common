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

use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;

class Response
{
    /** @var ScenarioState */
    private $newScenarioState;
    /** @var Delay */
    private $delayMillis;

    public function __construct(
        ?Delay $delayMillis = null,
        ?ScenarioState $newScenarioState = null
    ) {
        $this->newScenarioState = $newScenarioState;
        $this->delayMillis = $delayMillis;
    }

    public static function createEmpty(): self
    {
        return new self();
    }

    public function hasNewScenarioState(): bool
    {
        return null !== $this->newScenarioState;
    }

    public function getNewScenarioState(): ?ScenarioState
    {
        return $this->newScenarioState;
    }

    public function hasDelayMillis(): bool
    {
        return $this->delayMillis !== null;
    }

    public function getDelayMillis() : ?Delay
    {
        return $this->delayMillis;
    }

    public function isHttpResponse(): bool
    {
        return false;
    }

    public function isProxyResponse(): bool
    {
        return false;
    }
}
