<?php

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Expectation;

interface ArrayToExpectationConverter
{
    public function convert(array $expectationArray): Expectation;
}
