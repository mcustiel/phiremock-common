<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

class Matcher
{
    /**
     * @var string
     */
    private $matcher;

    /**
     * @param string $matcher
     */
    public function __construct($matcher)
    {
        $this->ensureIsValidMatcher($matcher);
        $this->matcher = $matcher;
    }

    public static function equalTo()
    {
        return new self(MatchersEnum::EQUAL_TO);
    }

    public static function sameString()
    {
        return new self(MatchersEnum::SAME_STRING);
    }

    public static function sameJson()
    {
        return new self(MatchersEnum::SAME_JSON);
    }

    public static function contains()
    {
        return new self(MatchersEnum::CONTAINS);
    }

    public static function matches()
    {
        return new self(MatchersEnum::MATCHES);
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->matcher;
    }

    private function ensureIsValidMatcher($matcher)
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
