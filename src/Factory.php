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

namespace Mcustiel\Phiremock;

use Mcustiel\Phiremock\Common\Http\Implementation\GuzzleConnection;
use Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface;
use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverterLocator;
use Mcustiel\Phiremock\Common\Utils\V1\Factory as FactoryV1;
use Mcustiel\Phiremock\Common\Utils\V2\Factory as FactoryV2;

class Factory
{
    public function createV1UtilsFactory(): FactoryV1
    {
        return new FactoryV1($this);
    }

    public function createV2UtilsFactory(): FactoryV2
    {
        return new FactoryV2($this);
    }

    public function createExpectationToArrayConverterLocator(): ExpectationToArrayConverterLocator
    {
        return new ExpectationToArrayConverterLocator(
            $this->createV1UtilsFactory(),
            $this->createV2UtilsFactory()
        );
    }

    public function createArrayToExpectationConverterLocator(): ArrayToExpectationConverterLocator
    {
        return new ArrayToExpectationConverterLocator(
            $this->createV1UtilsFactory(),
            $this->createV2UtilsFactory()
        );
    }

    public function createRemoteConnectionInterface(): RemoteConnectionInterface
    {
        return new GuzzleConnection(new \GuzzleHttp\Client());
    }
}
