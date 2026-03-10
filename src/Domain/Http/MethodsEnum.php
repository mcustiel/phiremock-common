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

namespace Mcustiel\Phiremock\Domain\Http;

class MethodsEnum
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
    public const FETCH = 'FETCH';
    public const HEAD = 'HEAD';
    public const OPTIONS = 'OPTIONS';
    public const PATCH = 'PATCH';
    public const LINK = 'LINK';

    private const VALID_METHODS = [
        self::GET,
        self::POST,
        self::PUT,
        self::DELETE,
        self::PATCH,
        self::FETCH,
        self::OPTIONS,
        self::HEAD,
        self::LINK,
    ];

    public static function isValid(string $method): bool
    {
        return \in_array(strtoupper($method), self::VALID_METHODS, true);
    }
}
