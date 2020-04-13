<?php

namespace Mcustiel\Phiremock\Domain\Http;

class HeaderValue
{
    /** @var string * */
    private $headerValue;

    /** @param string $headerValue */
    public function __construct($headerValue)
    {
        $this->ensureIsValidHeaderValue($headerValue);
        $this->headerValue = $headerValue;
    }

    /** @return string */
    public function asString()
    {
        return $this->headerValue;
    }

    private function ensureIsValidHeaderValue($headerValue)
    {
        if (!\is_string($headerValue)) {
            throw new \InvalidArgumentException(sprintf('Header value must be a string. Got: %s', \gettype($headerValue)));
        }
    }
}
