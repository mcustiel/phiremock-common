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

use Mcustiel\Phiremock\Common\Utils\V1\ArrayToRequestConditionConverter as ArrayToRequestConditionConverterV1;
use Mcustiel\Phiremock\Domain\Condition\Conditions\MethodCondition;

class ArrayToRequestConditionConverter extends ArrayToRequestConditionConverterV1
{
    protected function convertMethodCondition(array $requestArray): ?MethodCondition
    {
        if (!empty($requestArray['method'])) {
            $methodCondition = $requestArray['method'];
            if (!\is_array($methodCondition)) {
                throw new \InvalidArgumentException('Method condition is invalid: ' . var_export($methodCondition, true));
            }
            $value = current($methodCondition);
            if (!\is_string($value)) {
                throw new \InvalidArgumentException('Invalid condition value. Expected string, got: ' . \gettype($value));
            }

            return new MethodCondition(
                $this->getMatcherFactory()->createFrom(key($methodCondition), $value)
            );
        }

        return null;
    }
}
