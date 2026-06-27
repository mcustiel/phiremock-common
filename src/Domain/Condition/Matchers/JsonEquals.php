<?php

declare(strict_types=1);

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

namespace Mcustiel\Phiremock\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Common\Utils\ArraysHelper;
use Mcustiel\Phiremock\Domain\Condition\Json;
use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;

class JsonEquals extends Matcher
{
    use ParsesJsonValues;

    public function __construct(Json $string)
    {
        parent::__construct($string);
    }

    public function matches($value): bool
    {
        if (\is_string($value)) {
            $requestValue = $this->getParsedJsonValue($value);
            if ($this->isInvalidNonNullJson($value, $requestValue)) {
                return false;
            }
        } else {
            $requestValue = $value;
        }
        $configValue = $this->getCheckValue()->get();

        if (\is_array($requestValue) && \is_array($configValue)) {
            return ArraysHelper::areRecursivelyEquals($requestValue, $configValue);
        }

        return $requestValue === $configValue;
    }

    public function getName(): string
    {
        return MatchersEnum::SAME_JSON;
    }
}
