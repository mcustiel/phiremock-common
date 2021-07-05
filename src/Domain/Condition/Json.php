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

namespace Mcustiel\Phiremock\Domain\Condition;

class Json extends ConditionValue
{
    public function __construct(string $string)
    {
        parent::__construct($this->getDecodedJson($string));
    }

    public function asString(): string
    {
        return json_encode(
            $this->get(),
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRESERVE_ZERO_FRACTION
        );
    }

    private function getDecodedJson(string $string): array
    {
        $decodedJson = json_decode($string, true);
        if (json_last_error() !== \JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(sprintf('Invalid json: %s. Parsing error: %s', $string, json_last_error_msg()));
        }

        return $decodedJson;
    }
}
