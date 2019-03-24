<?php

namespace Mcustiel\Phiremock\Domain\Http;

class Uri
{
    /** @var string * */
    private $uri;

    /**
     * @param string $uri
     */
    public function __construct($uri)
    {
        $this->ensureIsValidUri($uri);
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->uri;
    }

    private function ensureIsValidUri($uri)
    {
        if (!\is_string($uri)) {
            throw new \InvalidArgumentException(
                sprintf('Uri must be a string. Got: %s', \gettype($uri))
            );
        }

        if (false === filter_var($uri, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid http uri: %s', var_export($uri, true))
            );
        }
    }
}
