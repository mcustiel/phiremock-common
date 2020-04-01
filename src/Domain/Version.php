<?php
namespace Mcustiel\Phiremock\Domain;

class Version
{
    /** @var int */
    private $version;

    public function __construct(int $version)
    {
        $this->ensureVersionIsCorrect($version);
        $this->version = $version;
    }

    public function asInt(): int
    {
        return $this->version;
    }

    private function ensureVersionIsCorrect(int $version): void
    {
        if ($version < 1 || $version > 2) {
            throw new \InvalidArgumentException(sprintf('Invalid version: %s', $version));
        }
    }
}
