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

class Method
{
    /** @var string * */
    private $method;

    public function __construct(string $method)
    {
        $this->ensureIsValidHttpMethod($method);
        $this->method = strtolower($method);
    }

    public static function get(): self
    {
        return new self(MethodsEnum::GET);
    }

    public static function post(): self
    {
        return new self(MethodsEnum::POST);
    }

    public static function put(): self
    {
        return new self(MethodsEnum::PUT);
    }

    public static function delete(): self
    {
        return new self(MethodsEnum::DELETE);
    }

    public static function fetch(): self
    {
        return new self(MethodsEnum::FETCH);
    }

    public static function options(): self
    {
        return new self(MethodsEnum::OPTIONS);
    }

    public static function patch(): self
    {
        return new self(MethodsEnum::PATCH);
    }

    public static function head(): self
    {
        return new self(MethodsEnum::HEAD);
    }

    public function asString(): string
    {
        return $this->method;
    }

    public function equals(self $other): bool
    {
        return $this->asString() === $other->asString();
    }

    private function ensureIsValidHttpMethod(string $method): void
    {
        var_export('ensurer');
        if (!MethodsEnum::isValid($method)) {
            throw new \InvalidArgumentException(sprintf('Invalid http method: %s', var_export($method, true)));
        }
    }
}
