<?php

namespace Mcustiel\Phiremock\Domain\Http;

class Body
{
    /** @var string * */
    private $body;

    /** @param string $body */
    public function __construct($body)
    {
        $this->ensureIsValidBody($body);
        $this->body = $body;
    }

    /** @return bool */
    public function isTextBody()
    {
        return true;
    }

    /** @return Body */
    public static function createEmpty()
    {
        return new static('');
    }

    /** @return string */
    public function asString()
    {
        return $this->body;
    }

    /**
     * @param Body $other
     *
     * @return bool
     */
    public function equals($other)
    {
        return $this->asString() === $other->asString();
    }

    private function ensureIsValidBody($body)
    {
        if (!\is_string($body)) {
            throw new \InvalidArgumentException(
                sprintf('Body must be a string. Got: %s', \gettype($body))
            );
        }
    }
}
