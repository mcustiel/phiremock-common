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

namespace Mcustiel\Phiremock\Domain\Condition\Conditions;

use Mcustiel\Phiremock\Domain\AbstractArrayCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderName;

/** @method HeaderCondition current() */
final class HeaderConditionCollection extends AbstractArrayCollection
{
    public function __toString()
    {
        $string = '';
        /** @var HeaderName $headerName */
        /** @var HeaderCondition $headerCondition */
        foreach ($this as $headerName => $headerCondition) {
            $string .= $headerName->asString() . ' => ' . $headerCondition->__toString();
        }

        return $string;
    }

    public function setHeaderCondition(HeaderName $header, HeaderCondition $condition)
    {
        parent::set($header->asString(), $condition);
    }

    /** @return HeaderName */
    public function key()
    {
        return new HeaderName(parent::key());
    }

    public function iterator()
    {
        return new HeaderConditionIterator($this->array);
    }
}
