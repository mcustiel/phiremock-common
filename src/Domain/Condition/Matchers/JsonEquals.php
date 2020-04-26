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

namespace Mcustiel\Phiremock\Domain\Condition\Matchers;

use Mcustiel\Phiremock\Common\Utils\ArraysHelper;
use Mcustiel\Phiremock\Domain\Condition\Json;
use Mcustiel\Phiremock\Domain\Condition\MatchersEnum;

class JsonEquals extends Matcher
{
    public function __construct(Json $string)
    {
        parent::__construct($string);
    }

    public function matches($value): bool
    {
        if (\is_string($value)) {
            $requestValue = $this->getParsedValue($value);
        } else {
            $requestValue = $value;
        }
       $configValue = $this->getCheckValue()->get();

        if (!\is_array($requestValue)) {
            return false;
        }

        return ArraysHelper::areRecursivelyEquals($requestValue, $configValue);
    }

    public function getName(): string
    {
        return MatchersEnum::SAME_JSON;
    }

    private function decodeJson(string $value): array
    {
        $decodedValue = json_decode($value, true);
        if (JSON_ERROR_NONE !== json_last_error() || $decodedValue === null) {
            throw new \InvalidArgumentException('JSON parsing error: ' . json_last_error_msg());
        }

        return $decodedValue;
    }

    private function getParsedValue(string $value)
    {
        try {
            $requestValue = $this->decodeJson($value);
        } catch (\Throwable $e) {
            $requestValue = $value;
        }

        return $requestValue;
    }
}
