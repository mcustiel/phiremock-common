<?php

namespace Mcustiel\Phiremock\Domain\Conditions;

class Matcher
{
    /** @var string */
    private $matcher;

    /** @param string $matcher */
    public function __construct($matcher)
    {
        $this->ensureIsValidMatcher($matcher);
        $this->matcher = $matcher;
    }

    /** @return self */
    public static function equalTo()
    {
        return new static(MatchersEnum::EQUAL_TO);
    }

    /** @return self */
    public static function sameString()
    {
        return new static(MatchersEnum::SAME_STRING);
    }

    /** @return self */
    public static function sameJson()
    {
        return new static(MatchersEnum::SAME_JSON);
    }

    /** @return self */
    public static function contains()
    {
        return new static(MatchersEnum::CONTAINS);
    }

    /** @return self */
    public static function matches()
    {
        return new static(MatchersEnum::MATCHES);
    }

    /** @return string */
    public function asString()
    {
        return $this->matcher;
    }

    private function ensureIsValidMatcher($matcher)
    {
        if (!\is_string($matcher)) {
            throw new \InvalidArgumentException(sprintf('Matcher must be a string. Got: %s', \gettype($matcher)));
        }

        if (!MatchersEnum::isValidMatcher($matcher)) {
            throw new \InvalidArgumentException(sprintf('Invalid condition matcher specified: %s', $matcher));
        }
    }
}
