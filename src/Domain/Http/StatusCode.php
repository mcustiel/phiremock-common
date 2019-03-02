<?php

namespace Mcustiel\Phiremock\Domain\Http;

class StatusCode
{
    /** @var int * */
    private $statusCode;

    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        $this->ensureIsValidStatusCode($statusCode);
        $this->statusCode = $statusCode;
    }

    public static function createDefault()
    {
        return new self(200);
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->statusCode;
    }

    private function ensureIsValidStatusCode($statusCode)
    {
        if (!\is_int($statusCode)) {
            throw new \InvalidArgumentException(
                sprintf('Status code must be an integer. Got: %s', \gettype($statusCode))
            );
        }
        if ($statusCode < 100 || $statusCode >= 600) {
            throw new \InvalidArgumentException(
                sprintf('Invalid status code: %d', $statusCode)
            );
        }
    }
}
