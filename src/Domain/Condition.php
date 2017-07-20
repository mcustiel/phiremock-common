<?php

namespace Mcustiel\Phiremock\Domain;

class Condition implements \JsonSerializable
{
    /**
     * @var string
     */
    private $matcher;
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $matcher
     * @param value $value
     */
    public function __construct($matcher = null, $value = null)
    {
        $this->matcher = $matcher;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param string $matcher
     * @return \Mcustiel\Phiremock\Domain\Condition
     */
    public function setMatcher($matcher)
    {
        $this->matcher = $matcher;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return \Mcustiel\Phiremock\Domain\Condition
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [$this->matcher => $this->value];
    }
}
