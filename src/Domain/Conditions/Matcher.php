<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

class Matcher
{
    /** @var string */
    private $matcher;

    public function __construct(string $matcher)
    {
        $this->ensureIsValidMatcher($matcher);
        $this->matcher = $matcher;
    }

    public static function equalTo(): self
    {
        return new self(MatchersEnum::EQUAL_TO);
    }

    public static function sameString(): self
    {
        return new self(MatchersEnum::SAME_STRING);
    }

    public static function sameJson(): self
    {
        return new self(MatchersEnum::SAME_JSON);
    }

    public static function contains(): self
    {
        return new self(MatchersEnum::CONTAINS);
    }

    public static function matches(): self
    {
        return new self(MatchersEnum::MATCHES);
    }

    public function asString(): string
    {
        return $this->matcher;
    }

    private function ensureIsValidMatcher($matcher): void
    {
        if (!\is_string($matcher)) {
            throw new \InvalidArgumentException(
                sprintf('Matcher must be a string. Got: %s', \gettype($matcher))
            );
        }

        if (!MatchersEnum::isValidMatcher($matcher)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid matcher: %s', $matcher)
            );
        }
    }
}
