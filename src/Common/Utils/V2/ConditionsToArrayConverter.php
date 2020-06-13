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

namespace Mcustiel\Phiremock\Common\Utils\V2;

use Mcustiel\Phiremock\Common\Utils\RequestConditionToArrayConverter as ConverterV1;
use Mcustiel\Phiremock\Domain\Conditions;

class ConditionsToArrayConverter extends ConverterV1
{
    private function convertMethod(Conditions $request, array &$requestArray)
    {
        $method = $request->getMethod();
        $requestArray['method'] = null === $method ? null : [
            $method->getMatcher()->asString() => $method->getValue()->asString(),
        ];
    }
}
