<?php

namespace Mcustiel\Phiremock\Domain\Http;

class JsonPathName
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->ensureIsNotEmpty($path); 
        $this->path = $path;
    }

    public function asString(): string
    {
        return $this->path;
    }

    private function ensureIsNotEmpty(string $path): void
    {
        if ($path === '') {
            throw new \InvalidArgumentException('JSON path can\'t be empty');
        }
    }
}
