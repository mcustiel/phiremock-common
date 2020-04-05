<?php

namespace Mcustiel\Phiremock\Domain\Http;

class Uri
{
    /** @var string * */
    private $uri;

    public function __construct(string $uri)
    {
        $this->ensureIsValidUri($uri);
        $this->uri = $uri;
    }

    public function asString(): string
    {
        return $this->uri;
    }

    public function equals($other): bool
    {
        return $this->asString() === $other->asString();
    }

    private function ensureIsValidUri(string $uri): void
    {
        if (false === filter_var($uri, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(sprintf('Invalid http uri: %s', var_export($uri, true)));
        }
    }
}
