<?php

namespace Mcustiel\Phiremock\Domain\Http;

class HeaderName implements \JsonSerializable
{
    /** @var string * */
    private $headerName;

    /**
     * @param string $headerName
     */
    public function __construct($headerName)
    {
        $this->ensureIsValidHeaderName($headerName);
        $this->headerName = $headerName;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->headerName;
    }

    public function jsonSerialize()
    {
        return $this->headerName;
    }

    private function ensureIsValidHeaderName($headerName)
    {
        if (!\is_string($headerName)) {
            throw new \InvalidArgumentException(
                sprintf('Header name must be a string. Got: %s', \gettype($headerName))
            );
        }
    }
}
