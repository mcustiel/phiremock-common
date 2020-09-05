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

use Mcustiel\Phiremock\Domain\AbstractArrayIterator;
use Mcustiel\Phiremock\Domain\Http\FormFieldName;

/** @method FormFieldCondition current() */
final class FormFieldConditionIterator extends AbstractArrayIterator
{
    public function __toString()
    {
        $string = '';
        /** @var FormFieldName $parameterName */
        /** @var FormFieldCondition $fieldCondition */
        foreach ($this as $parameterName => $fieldCondition) {
            $string .= $parameterName->asString() . ' => ' . $fieldCondition->__toString();
        }

        return $string;
    }

    /** @return FormFieldName */
    public function key()
    {
        return new FormFieldName(parent::key());
    }
}
