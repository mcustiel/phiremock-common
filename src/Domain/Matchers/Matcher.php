<?php
namespace Mcustiel\Phiremock\Domain\Matchers;

abstract class Matcher
{
    /** @var mixed */
    private $checkValue;

    public function __construct($checkValue)
    {
        $this->checkValue = $checkValue;
    }

    public function asString(): string
    {
        return (string) $this->checkValue;
    }
}
