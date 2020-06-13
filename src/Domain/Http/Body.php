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

use Mcustiel\Phiremock\Common\StringStream;
use Psr\Http\Message\StreamInterface;

class Body
{
    /** @var string * */
    private $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }

    public function isTextBody(): bool
    {
        return true;
    }

    public static function createEmpty(): self
    {
        return new self('');
    }

    public function asString(): string
    {
        return $this->body;
    }

    public function asStream(): StreamInterface
    {
        return new StringStream($this->body);
    }

    public function equals(self $other): bool
    {
        return $this->asString() === $other->asString();
    }
}
