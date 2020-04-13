<?php

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
